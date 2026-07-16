<?php

namespace Tests\Feature;

use App\Models\ContactRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_is_accessible(): void
    {
        $response = $this->get('/kontakt');
        $response->assertStatus(200);
        $response->assertSee('Zamów darmową wycenę');
    }

    public function test_contact_form_submits_successfully(): void
    {
        $response = $this->post('/kontakt', [
            'name' => 'Jan Kowalski',
            'company_name' => 'Test Sp. z o.o.',
            'email' => 'jan@test.pl',
            'phone' => '+48 123 456 789',
            'service_type' => 'biuro',
            'message' => 'Proszę o wycenę sprzątania biura 50m2.',
        ]);

        $response->assertRedirect(route('kontakt'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_requests', [
            'email' => 'jan@test.pl',
            'service_type' => 'biuro',
        ]);
    }

    public function test_contact_form_validates_required_fields(): void
    {
        $response = $this->post('/kontakt', []);

        $response->assertSessionHasErrors(['name', 'email', 'phone', 'service_type']);
    }

    public function test_contact_form_validates_email_format(): void
    {
        $response = $this->post('/kontakt', [
            'name' => 'Jan',
            'email' => 'not-an-email',
            'phone' => '123',
            'service_type' => 'biuro',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_contact_form_validates_service_type(): void
    {
        $response = $this->post('/kontakt', [
            'name' => 'Jan',
            'email' => 'jan@test.pl',
            'phone' => '123',
            'service_type' => 'invalid_type',
        ]);

        $response->assertSessionHasErrors(['service_type']);
    }
}
