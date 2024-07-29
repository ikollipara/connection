<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class Editor implements Htmlable
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function toHtml()
    {
        //
    }

    private function extractParagraph(array $block)
    {
        return new HtmlString("<p>{$block["data"]["text"]}</p>");
    }
}
