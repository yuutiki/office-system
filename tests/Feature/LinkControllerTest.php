<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Link;
use App\Models\User;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LinkControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Department $department;

    protected function setUp(): void
    {
        parent::setUp();

        // テスト用ユーザー作成＆ログイン
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        // 関連部門を作成
        $this->department = Department::factory()->create([
            'name' => '情報システム部',
        ]);
    }

    /** @test */
    public function index_returns_success_and_contains_links()
    {
        $link = Link::factory()->create(['display_name' => 'Test Link']);

        $response = $this->get(route('link.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Test Link');
    }

    /** @test */
    public function index_can_filter_by_display_name()
    {
        Link::factory()->create(['display_name' => 'CampusOne Portal']);
        Link::factory()->create(['display_name' => 'Other Link']);

        $response = $this->get(route('link.index', ['display_name' => 'Campus']));

        $response->assertStatus(200);
        $response->assertSee('CampusOne Portal');
        $response->assertDontSee('Other Link');
    }

    /** @test */
    public function store_creates_a_new_link()
    {
        $data = [
            'display_name' => 'New Link',
            'display_order' => 1,
            'url' => 'https://example.com',
            'department_id' => $this->department->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ];

        $response = $this->post(route('link.store'), $data);

        $response->assertRedirect(route('link.index'));
        $this->assertDatabaseHas('links', ['display_name' => 'New Link']);
    }

    /** @test */
    public function update_modifies_link()
    {
        $link = Link::factory()->create([
            'display_name' => 'Old Name',
            'department_id' => $this->department->id,
        ]);

        $data = [
            'display_name' => 'Updated Link',
            'display_order' => 10,
            'url' => 'https://updated.com',
            'department_id' => $this->department->id,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ];

        $response = $this->put(route('link.update', $link), $data);

        $response->assertRedirect(route('link.index'));
        $this->assertDatabaseHas('links', [
            'id' => $link->id,
            'display_name' => 'Updated Link',
        ]);
    }

    /** @test */
    public function destroy_deletes_link()
    {
        $link = Link::factory()->create();

        $response = $this->delete(route('link.destroy', $link->id));

        $response->assertRedirect(route('link.index'));
        $this->assertDatabaseMissing('links', ['id' => $link->id]);
    }

    /** @test */
    public function index_can_filter_by_department_id()
    {
        $childDept = Department::factory()->create([
            'parent_id' => $this->department->id,
            'name' => '子部門'
        ]);

        $parentLink = Link::factory()->create([
            'display_name' => 'Parent Link',
            'department_id' => $this->department->id
        ]);

        $childLink = Link::factory()->create([
            'display_name' => 'Child Link',
            'department_id' => $childDept->id
        ]);

        $response = $this->get(route('link.index', [
            'department_id' => $this->department->id
        ]));

        $response->assertStatus(200);
        $response->assertSee('Parent Link');
        $response->assertSee('Child Link');
    }
}
