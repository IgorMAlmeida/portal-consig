<?php

namespace App\Services;

use DOMDocument;

class GetToken {

    public function getInputToken($html) {
        libxml_use_internal_errors(true);
        $count = 0;

        $doc = new DOMDocument();
        $doc->loadHTML($html);
        libxml_use_internal_errors(false);

        $tags = $doc->getElementsByTagName('input');

        foreach($tags as $tag)
        {
            $count++;
        
            if($tag->getAttribute('name') == "__RequestVerificationToken")
            {
                $token = $tag->getAttribute('value');
            }
        }
        
        return $token;
    }
}
