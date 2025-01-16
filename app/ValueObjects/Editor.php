<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;

class Editor implements Arrayable, Htmlable
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function toArray()
    {
        return $this->data;
    }

    public function toHtml()
    {
        $content = collect($this->data['blocks'])
            ->map(fn ($block) => $this->extractBlock($block))
            ->map(fn ($block) => $block->toHtml())
            ->join('');

        return new HtmlString("<article class=\"content is-medium\">{$content}</article>");
    }

    public function toJson(bool $parse = false)
    {
        if ($parse) {
            return Js::from($this->data);
        }

        return Js::encode($this->data);
    }

    public static function fromJson(string $json)
    {
        return new self(json_decode($json, true));
    }

    private function extractBlock(array $block)
    {
        switch ($block['type']) {
            case 'paragraph':
                return $this->extractParagraph($block);
            case 'header':
                return $this->extractHeader($block);
            case 'attaches':
                return $this->extractAttaches($block);
            case 'delimiter':
                return $this->extractDelimiter($block);
            case 'image':
                return $this->extractImage($block);
            case 'quote':
                return $this->extractQuote($block);
            case 'table':
                return $this->extractTable($block);
            case 'embed':
                return $this->extractEmbed($block);
            case 'code':
                return $this->extractCode($block);
            case 'list':
                return $this->extractNestedList($block);
            default:
                return '';
        }
    }

    private function extractParagraph(array $block)
    {
        $text = $block['data']['text'];

        return new HtmlString("<p>{$text}</p>");
    }

    private function extractHeader(array $block)
    {
        $level = $block['data']['level'];
        $text = $block['data']['text'];

        return new HtmlString("<h{$level}>{$text}</h{$level}>");
    }

    private function extractAttaches(array $block)
    {
        $url = $block['data']['file']['url'];
        $title = $block['data']['title'];
        $name = data_get($block, 'data.file.name', $title);

        return new HtmlString("<a download filname=\"{$name}\" href=\"{$url}\">{$title}</a>");
    }

    private function extractDelimiter(array $block)
    {
        return new HtmlString('<hr>');
    }

    private function extractImage(array $block)
    {
        $url = $block['data']['file']['url'];
        $caption = data_get($block, 'data.caption', '');

        return new HtmlString("<img src=\"{$url}\" alt=\"{$caption}\">");
    }

    private function extractQuote(array $block)
    {
        $text = $block['data']['text'];
        $caption = data_get($block, 'data.caption', '');

        return new HtmlString("<blockquote>{$text}<footer>{$caption}</footer></blockquote>");
    }

    private function extractTable(array $block)
    {
        $withHeadings = data_get($block, 'data.withHeadings', false);
        if ($withHeadings) {
            $headings = collect($block['data']['content'][0])
                ->map(fn ($heading) => "<th>{$heading}</th>")
                ->join('');
            $block['data']['content'] = collect($block['data']['content'])
                ->slice(1)
                ->toArray();
            $header = "<thead><tr>{$headings}</tr></thead>";
        } else {
            $header = '';
        }

        $content = collect($block['data']['content'])
            ->map(fn ($row) => '<tr>'.collect($row)
                ->map(fn ($cell) => "<td>{$cell}</td>")
                ->join('').'</tr>')
            ->join('');

        return new HtmlString("<table>{$header}<tbody>{$content}</tbody></table>");
    }

    private function extractEmbed(array $block)
    {
        $embedUrl = $block['data']['embed'];
        $caption = data_get($block, 'data.caption', '');
        $width = data_get($block, 'data.width', '300%');
        $height = data_get($block, 'data.height', '150');

        return new HtmlString("<iframe src=\"{$embedUrl}\" width=\"{$width}\" height=\"{$height}\"></iframe><p>{$caption}</p>");
    }

    private function extractCode(array $block)
    {
        $code = $block['data']['code'];

        return new HtmlString("<pre><code>{$code}</code></pre>");
    }

    private function extractNestedList(array $block)
    {
        $style = $block['data']['style'] === 'ordered' ? 'ol' : 'ul';
        $content = collect($block['data']['items'])
            ->map(fn ($item) => $this->extractItems($item, $style))
            ->join('');

        return new HtmlString("<{$style}>{$content}</{$style}>");
    }

    private function extractItems(array $items, string $style)
    {
        $hasItems = filled($items['items']);

        if ($hasItems) {
            return "<li>{$items['content']}<{$style}>".$this->extractItems($items['items'], $style)."</{$style}></li>";
        } else {
            return new HtmlString("<li>{$items['content']}</li>");
        }
    }
}
