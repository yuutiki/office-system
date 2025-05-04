<?php

namespace App\Http\Controllers;

use App\Models\ClientContactCheckboxOption;
use App\Models\ClientContact;
use Illuminate\Http\Request;

class ClientContactCheckboxOptionController extends Controller
{
    public function index()
    {
        $checkboxOptions = ClientContactCheckboxOption::orderBy('display_order')->get();
        return view('masters.client-contact-checkbox.index', compact('checkboxOptions'));
    }

    public function create()
    {
        return view('masters.client-contact-checkbox.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:client_contact_checkbox_options',
            'label' => 'required|string|max:255',
        ]);
        
        $lastOrder = ClientContactCheckboxOption::max('display_order') ?? 0;
        
        $option = new ClientContactCheckboxOption();
        $option->name = $validated['name'];
        $option->label = $validated['label'];
        $option->display_order = $lastOrder + 1;
        $option->save();
        
        // 既存のclient_contactレコードに対してデフォルト値を設定
        $clientContacts = ClientContact::all();
        foreach ($clientContacts as $contact) {
            $contact->checkboxOptions()->attach($option->id, ['value' => false]);
        }
        
        return redirect()->route('client-contacts.checkbox-options.index')->with('success', 'チェックボックスが追加されました');
    }

    public function show(ClientContactCheckboxOption $clientContactCheckboxOption)
    {
        //
    }

    public function edit(ClientContactCheckboxOption $clientContactCheckboxOption)
    {
        return view('masters.client-contact-checkbox.edit', compact('clientContactCheckboxOption'));
    }

    public function update(Request $request, ClientContactCheckboxOption $clientContactCheckboxOption)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:client_contact_checkbox_options,name,' . $clientContactCheckboxOption->id,
            'label' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);
        
        $clientContactCheckboxOption->name = $validated['name'];
        $clientContactCheckboxOption->label = $validated['label'];
        $clientContactCheckboxOption->is_active = $request->has('is_active');
        $clientContactCheckboxOption->save();
        
        return redirect()->route('client-contacts.checkbox-options.index')->with('success', 'チェックボックスが更新されました');
    }

    public function destroy(ClientContactCheckboxOption $clientContactCheckboxOption)
    {
        //
    }

    // アクティブ/非アクティブ切り替え
    public function toggleActive(ClientContactCheckboxOption $clientContactCheckboxOption)
    {
        $clientContactCheckboxOption->is_active = !$clientContactCheckboxOption->is_active;
        $clientContactCheckboxOption->save();
        
        return redirect()->route('client-contacts.checkbox-options.index')->with('success', 'チェックボックスの状態が変更されました');
    }

    // 並び替え処理
    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:client_contact_checkbox_options,id',
        ]);
        
        foreach ($validated['ids'] as $index => $id) {
            $option = ClientContactCheckboxOption::findOrFail($id);
            $option->display_order = $index + 1;
            $option->save();
        }
        
        return response()->json(['success' => true]);
    }
}
