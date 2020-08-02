# text-inline

### Laravel Nova Date Inline Field

#### This package allow you to edit a text field in the index page with one click

## Installation

        composer require ronnytorresmtz/textinline

## Usage

### Make it editable

```php
use Ronnytorresmtz\TextInline\TextInline;

public function fields()
{
    return [
        TextInline::make('Name')
            ->inlineOnIndex(),
    ];
}
```

To edit the text field you need to click it on, and base on the `saveOn` event defined the text field value will be store in the database.

If you press the Esc key the field text will return to a no editable mode or if the text field lost the focus.

This method also accepts a closure with the current request if you want to make it editable dynamically:

```php
public function fields()
{
    return [
        InlineText::make('Name')
            ->inlineOnIndex(function (NovaRequest $request) {
                return $request->user()->isAdmin();
            }),
    ];
}
```

### Updating field value

The default trigger to save the value is by pressing the Enter key (keyup.enter). If you wish to use a different event trigger to update the value you can use the `saveOn()` method that accepts an argument corresponding to a javascript event:

```php
public function fields()
{
    return [
        InlineText::make('Name')
            ->inlineOnIndex()
            ->saveOn('blur'),
    ];
}
```

### Updating field value

The default trigger to save the value is by pressing the `Enter` key (`keyup.enter`). If you wish to use a different event trigger to update the value you can use the `saveOn()` method that accepts an argument corresponding to a javascript event:

```php
public function fields()
{
    return [
        InlineText::make('Name')
            ->inlineOnIndex()
            ->saveOn('blur'),
    ];
}
```

### Key event modifiers

You can also specify the key event modifier:

```php
public function fields()
{
    return [
        InlineText::make('Name')
            ->inlineOnIndex()
            ->saveOn('keyup.shift'),
    ];
}
```

## Credits

The credit for this package belongs to `PDMFC` I just add the clickable functionality to enable the edit mode and add one listener for blur event to enable the readonly mode. Also I eliminate the refreshTable method.

This package was based on the package [pdmfc/nova-inline-text](http://https://github.com/pdmfc/nova-inline-text/) 
