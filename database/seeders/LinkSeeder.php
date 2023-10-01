<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Link;


class LinkSeeder extends Seeder
{
    public function run(): void
    {
        Link::create([
            'display_name' => '出退勤',
            'display_order' => '1',
            'url' => 'https://e-timecard.systemd.co.jp:18443/WebTimeCard/Auth/Login?ReturnUrl=%2FWebTimeCard%2FHome%2FList',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Link::create([
            'display_name' => '楽楽精算',
            'display_order' => '2',
            'url' => 'https://rsintro.rakurakuseisan.jp/k348U5nsLKa/',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Link::create([
            'display_name' => 'サイボウズ',
            'display_order' => '3',
            'url' => 'https://cybozu.systemd.co.jp/scripts/cb/ag.exe',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Link::create([
            'display_name' => '郵送依頼',
            'display_order' => '4',
            'url' => 'https://forms.office.com/pages/responsepage.aspx?id=e5XvZVYh8U20o9heOOxoOCpVk7Q3n19MuDAAwVSxAMJUN0hCWEJaQUFVUUJGNjBBRTZYNFNHSFlaVy4u',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Link::create([
            'display_name' => 'どこキャビ',
            'display_order' => '5',
            'url' => 'https://fwddoc.dococab.jp/fw/dfw?AGENT_DFW=https%3a%2f%2fb.dococab.jp%2fagt&path=%2fapp3%2fvbw%2findex.html&query=lf%3ddlv%252Frequest&tid=TID20230303161732393792A0-7fc9-e73fa880-agent_docab#dlv/request',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Link::create([
            'display_name' => 'ナレッジ',
            'display_order' => '6',
            'url' => 'https://gridy.jp/home',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Link::create([
            'display_name' => 'クラウドWiki',
            'display_order' => '7',
            'url' => 'http://cloudunyo/wordpress/',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Link::create([
            'display_name' => '制度変更',
            'display_order' => '8',
            'url' => 'http://getsserver:50001/wordpress/',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Link::create([
            'display_name' => 'NTR support',
            'display_order' => '9',
            'url' => 'https://www.ntrsupport.jp/setbox/',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Link::create([
            'display_name' => 'Progate',
            'display_order' => '10',
            'url' => 'https://prog-8.com/dashboard',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
