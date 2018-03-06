<?php

namespace Tests\Feature\Feature;

use App\Article;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
//    public function testsArticlesAreCreatedCorrectly()
//    {
//        $user = factory(User::class)->create();
//        $token = $user->generateToken();
//        $headers = ['Authorization' => "Bearer $token"];
//        $payload = [
//            'title' => 'Lorem',
//            'body' => 'Ipsum',
//        ];
//
//        $this->json('POST', '/api/articles', $payload, $headers)
//            ->assertStatus(200)
//            ->assertJson(['id' => 1, 'title' => 'Lorem', 'body' => 'Ipsum']);
//    }

    public function testsArticlesAreUpdatedCorrectly()
    {

        $password = Hash::make('toptal');
        $user =  User::create([
            'name' => 'Administrator',
            'email' => 'maxim@test.com',
            'password' => $password,
        ]);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $article = Article::create([
            'title' => 'Lorem',
            'body' => 'Ipsum',
        ]);

        $payload = [
            'title' => 'Lorem',
            'body' => 'Ipsum',
        ];

        $response = $this->json('PUT', '/api/articles/' . $article->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'id' => 1,
                'title' => 'Lorem',
                'body' => 'Ipsum'
            ]);
    }

    public function testsArtilcesAreDeletedCorrectly()
    {
        $password = Hash::make('toptal');
        $user =  User::create([
            'name' => 'Administrator',
            'email' => 'maxim@test.com',
            'password' => $password,
        ]);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $article = Article::create([
            'title' => 'Lorem',
            'body' => 'Ipsum',
        ]);

        $this->json('DELETE', '/api/articles/' . $article->id, [], $headers)
            ->assertStatus(204);
    }

    public function testArticlesAreListedCorrectly()
    {
       Article::create([
            'title' => 'First Article',
            'body' => 'First Body',
        ]);

        Article::create([
            'title' => 'Second Article',
            'body' => 'Second Body',
        ]);

                $password = Hash::make('toptal');
        $user =  User::create([
            'name' => 'Administrator',
            'email' => 'maxim@test.com',
            'password' => $password,
        ]);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/articles', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                [ 'title' => 'First Article', 'body' => 'First Body' ],
                [ 'title' => 'Second Article', 'body' => 'Second Body' ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'body', 'title', 'created_at', 'updated_at'],
            ]);
    }
}
