<?php

class SlugTest extends TestCase
{
    /** @var \MbSlug */
    public $slug;

    public function setUp()
    {
        $this->slug = new \MbSlug();
    }

    /**
     * @test
     */
    public function Slugアルファベット生成テスト()
    {
        $this->assertSame('abcdefg', $this->slug->create('abcdefg'));
        $this->assertSame('abcdefg', $this->slug->create('aBCdefG'));
        $this->assertSame('-abcdefg-', $this->slug->create('  abcdefg  '));
        $this->assertSame('-abcdefg-', $this->slug->create('  AbcDefG  '));
        $this->assertSame('-abcdefg-', $this->slug->create(' abcdefg  '));
        $this->assertSame('a-b-c-d-e-f-g-', $this->slug->create('a  b c d e f  g  '));
        $this->assertSame('a-b-c-d-efg', $this->slug->create('a      b c    d       efg'));
    }

    /**
     * @test
     */
    public function Slug日本語生成テスト()
    {
        $this->assertSame('あいうえお', $this->slug->create('あいうえお'));
        $this->assertSame('あ-いう-え-お', $this->slug->create('あ　いう え お'));
        $this->assertSame('アイウエオ', $this->slug->create('アイウエオ'));
        $this->assertSame('亞いウエ緒', $this->slug->create('亞いウエ緒'));
        $this->assertSame('あいうえお', $this->slug->create('あ,い、う・えお。'));
        $this->assertSame('-あいうえお-', $this->slug->create(' あ,い、う・えお。　'));
        $this->assertSame('', $this->slug->create('！？'));
        $this->assertSame('１２３４５６', $this->slug->create('１２３４５６'));
        $this->assertSame('１2３-４５-6', $this->slug->create('１2３　４５ 6'));
    }

    /**
     * @test
     */
    public function Slug混在生成テスト()
    {
        $this->assertSame('あaいiうuえeおo', $this->slug->create('あaいiうuえeおo'));
        $this->assertSame('あa-いiうuえe-おo', $this->slug->create('あa いiうuえe おo'));
        $this->assertSame('あa-いiうuえe-おo', $this->slug->create('あa        いiうuえe 　　　　おo'));
    }
}

class MbSlug {

    /**
     * @param $string
     * @param string $separator
     * @return string
     */
    public function create($string, $separator = '-')
    {
        $slugTitle = e($string);
        $slugTitle = preg_replace('/　/', ' ', $slugTitle);
        $slugTitle = preg_replace('/\s+/', ' ', $slugTitle);

        $flip = $separator == '-' ? '_' : '-';
        $title = preg_replace('!['.preg_quote($flip).']+!u', $separator, $slugTitle);
        // Remove all characters that are not the separator, letters, numbers, or whitespace.
        $title = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', mb_strtolower($title));
        // Replace all separator characters and whitespace by a single separator
        $title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);
        return trim(preg_replace('/ /', '-', $title));
    }
}