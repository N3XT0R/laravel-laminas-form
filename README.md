# Laravel Laminas Form
[![Build Status](https://travis-ci.com/kawax/laravel-laminas-form.svg?branch=master)](https://travis-ci.com/kawax/laravel-laminas-form)
[![Maintainability](https://api.codeclimate.com/v1/badges/21666cb8ec565a23d92c/maintainability)](https://codeclimate.com/github/kawax/laravel-laminas-form/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/21666cb8ec565a23d92c/test_coverage)](https://codeclimate.com/github/kawax/laravel-laminas-form/test_coverage)

![Laravel Laminas Form](screenshot.png)

https://docs.laminas.dev/laminas-form/

## Requirements
- PHP >= 7.2
- Laravel >= 6.0

## Installation

```
composer require revolution/laravel-laminas-form
```

### Suggest from LaminasForm
https://github.com/laminas/laminas-form/blob/master/composer.json

```json
        "laminas/laminas-captcha": "^2.7.1, required for using CAPTCHA form elements",
        "laminas/laminas-code": "^2.6 || ^3.0, required to use laminas-form annotations support",
        "laminas/laminas-eventmanager": "^2.6.2 || ^3.0, reuired for laminas-form annotations support",
        "laminas/laminas-recaptcha": "in order to use the ReCaptcha form element"
```

## Demo
https://github.com/kawax/laravel-zend-form-project

## Artisan command

```
php artisan make:form SampleForm
```

app/Http/Forms/SampleForm.php

## Form class

```php
namespace App\Http\Forms;

use Revolution\LaminasForm\Form;
use Laminas\Form\Element;

class SampleForm extends Form
{
    /**
     * Create a new form.
     *
     * @param null|string $name
     *
     * @return void
     */
    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->setAttributes([
            'action' => url('/'),
            'method' => 'post',
        ]);

        $name = new Element\Text('name');
        $name->setAttributes([
            'id'    => 'name',
            'class' => 'form-control',
            'value' => old('name'),
        ]);
        $name->setLabel('Your name');
        $name->setLabelAttributes([
            'class' => 'col-sm-2 col-form-label',
        ]);
        $name->setOptions([
            'wrapper-class' => 'form-group row',
            'element-class' => 'col-sm-10',
        ]);

        $this->add($name);

        $this->add([
            'type'       => Element\Email::class,
            'name'       => 'email',
            'attributes' => [
                'id'    => 'email',
                'class' => 'form-control',
                'value' => old('email'),
            ],
            'options'    => [
                'label'            => 'Your email address',
                'label_attributes' => [
                    'class' => 'col-sm-2 col-form-label',
                ],
                'wrapper-class'    => 'form-group row',
                'element-class'    => 'col-sm-10',
            ],
        ]);

        $this->add([
            'type'       => Element\Hidden::class,
            'name'       => '_token',
            'attributes' => [
                'value' => csrf_token(),
            ],
        ]);

        $this->add([
            'name'       => 'send',
            'type'       => 'Submit',
            'attributes' => [
                'value' => 'Submit',
                'class' => 'btn btn-primary',
            ],
        ]);
    }
}
```

## Controller

```php
use App\Http\Forms\SampleForm;

    public function __invoke()
    {
        $form = new SampleForm();

        return view('form')->with(compact('form'));
    }
```

```php
use App\Http\Forms\SampleForm;

    public function __invoke(SampleForm $form)
    {
        return view('form')->with(compact('form'));
    }
```

## View

### Simple render

```php
{{ $form->render() }}
```

Same as LaminasForm's `echo $this->form($form);`

### Detail render

```php
@php
    $form->prepare();
@endphp

{!! $form->form()->openTag($form) !!}

{{ csrf_field() }}

<div class="form-group row">
    <label for="name" class="col-sm-3 col-form-label">{!! $form->get('name')->getLabel()  !!}</label>
    <div class="col-sm-9">
        {!! $form->formInput($form->get('name')) !!}
    </div>
</div>

<div class="form-group row">
    <label for="email" class="col-sm-3 col-form-label">{!! $form->get('email')->getLabel()  !!}</label>
    <div class="col-sm-9">
        {!! $form->formInput($form->get('email')) !!}
    </div>
</div>

<div class="form-group row">
    <div class="col-sm-9 offset-sm-3">
        {!! $form->formSubmit($form->get('send')) !!}
    </div>
</div>

{!! $form->form()->closeTag($form) !!}
```

Form object can call Laminas's ViewHelper by magic method.

See https://docs.laminas.dev/quick-start/

## ViewHelper render
```php
{{ $form->render('bootstrap4horizon') }}
```

https://github.com/kawax/laravel-laminas-form/blob/master/docs/helpers.md

## Validation
Use Laravel's FormRequest.

## LICENSE
MIT  
Copyright kawax
