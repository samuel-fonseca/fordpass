<?php

namespace App\Services\Parsers;

use DOMDocument;
use DOMNode;
use DOMNodeList;
use DOMXPath;

class DomParser implements Parser
{
    private DOMDocument $html;

    private DOMXPath $parser;

    public function __construct(
        protected string $data
    ) {
        $this->html = new DOMDocument();
        @$this->html->loadHTML($this->data);
        $this->parser = new DOMXPath($this->html);
    }

    public function find(string $query): DOMNodeList
    {
        return $this->parser->query($query);
    }

    public function findByClass(string $className): DOMNodeList
    {
        return $this->find(sprintf('//*[contains(@class, "%s")]', $className));
    }

    public function getAttribute(DOMNode $node, string $attribute): mixed
    {
        return $node->getAttribute($attribute);
    }
}
