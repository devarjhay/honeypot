# Honeypot: Spam Prevention
A simple spam prevention package for Laravel 5.4 and 5.5.

# Installation:
### Composer
Run this command inside your terminal to add the package into your project.
```
composer require devarjhay/honeypot
```

# Configuration
### Register the Honeypot Service Provider (Laravel 5.4 only)
Add the package to your application service providers in `config/app.php` file.
```php
'providers' => [

  /*
   * Laravel Framework Service Providers...
   */
   Illuminate\Translation\TranslationServiceProvider::class,
   Illuminate\Validation\ValidationServiceProvider::class,
   Illuminate\View\ViewServiceProvider::class,
   ...
   
   /*
    * Package Service Providers...
    */
   DevArjhay\Honeypot\Providers\HoneypotServiceProvider::class,
],
```

### Publish Config File and Translations
Optimize the application
```
php artisan optimize
```
Publish the package config file and translations to your application. Run this command inside your terminal.
```
php artisan vendor:publish --provider="DevArjhay\Honeypot\Providers\HoneypotServiceProvider"
```
Or, you may want to publish the file individually.
```
php artisan vendor:publish --provider="DevArjhay\Honeypot\Providers\HoneypotServiceProvider" --tag="config"
php artisan vendor:publish --provider="DevArjhay\Honeypot\Providers\HoneypotServiceProvider" --tag="lang"
```

# Usage
### Using Facades
Add the honeypot hidden input into your form by inserting `Honeypot::make(...)` like this:
```html
<form action="..." method="...">
    {!! Honeypot::make('honeypot_name', 'honeypot_time') !!}
</form>
```
### Using Helpers
```html
<form action="..." method="...">
    {!! honeypot('honeypot_name', 'honeypot_time') !!}
</form>
```
### Using Blade Templates
```html
<form action="..." method="...">
    @honeypot('honeypot_name', 'honeypot_time')
</form>
```
The `make` method will output the following HTML input. (The `honeypot_time` field will generate an encrypted tmestamps.
```html
<div id="honeypot_name_wrap" style="display: none;">
    <input type="text" name="honeypot_name" id="honeypot_name" value="" autocomplete="off">
    <input type="text" name="honeypot_time" id="honeypot_time" value="encrypted timestamp" autocomplete="off">
</div>
```
After adding the honeypot fields. Add the validation rules for the honeypot and honey time fields.
```php
$this->validate($request, [
    ...
    'honeypot_name' => 'honeypot',
    'honeypot_time' => 'required|honeytime:5'
]);
```
Please note that you need to specify the number of seconds in honeytime. It should take for the user to fill up the form. If it takes less time than that the form is considered as a spam submission.

I hope you enjoy getting a less spam when user submitting a form.

# Credits
This project was based on https://github.com/msurguy/Honeypot – Maksim Surguy<br>
Original work on https://github.com/ianlandsman/Honeypot – Ian Landsman

# License
MIT License

Copyright (c) 2017 Arjhay Delos Santos

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
