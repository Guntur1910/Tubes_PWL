@extends('layouts.user')

@section('title', 'Contact - ' . config('app.name'))

@section('content')

{{-- ===== Contact Area ===== --}}
<div class="contact_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="contact_form_area">
                    <h2>Get in Touch</h2>
                    <form action="#" method="post">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="contact-name">Name *</label>
                                    <input type="text" class="form-control" id="contact-name" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="contact-email">Email *</label>
                                    <input type="email" class="form-control" id="contact-email" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="message">Message *</label>
                                    <textarea class="form-control" name="message" id="message" cols="30" rows="10" placeholder="Message"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn essence-btn">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection