<?php

namespace Ronnytorresmtz\TextInline;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class TextInline extends Field
{
    /**
     * @var bool
     */
    protected $inlineOnIndex = false;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'text-inline';

    /**
     * The event trigger used to save the field value,
     *
     * @var string
     */
    protected $event = 'keyup.enter';

    /**
     * Allows field to be editable on index view.
     *
     * @param closure|null $callback
     * @return self
     */
    public function inlineOnIndex(callable $callback = null)
    {
        $inline = true;

        if (is_callable($callback)) {
            $inline = call_user_func($callback, resolve(NovaRequest::class));
        }

        $this->inlineOnIndex = $inline;

        return $this;
    }

    /**
     *
     */
    public function saveOn(string $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Resolve the field's value.
     *
     * @param  mixed  $resource
     * @param  string|null  $attribute
     * @return void
     */
    public function resolve($resource, $attribute = null)
    {
        parent::resolve($resource, $attribute);

        $this->withMeta([
            'inlineOnIndex' => $this->inlineOnIndex,
            'event' => $this->event,
        ]);
    }
}

