<?php

require_once __DIR__ . "/ResolverTestCase.php";

class CanonicalUrlResolverTest extends ResolverTestCase
{
    public function testConfig()
    {
        $this->markTestIncomplete('This needs to be updated to use the new site-based canonical url');

        $resolver = new \Concrete\Core\Url\Resolver\CanonicalUrlResolver(
            \Core::getFacadeApplication(),
            \Core::make('Concrete\Core\Http\Request'));

        $canonical = "http://example.com:1337";

        $old_value = \Config::get('concrete.seo.canonical_url');
        \Config::set('concrete.seo.canonical_url', $canonical);

        $this->assertEquals(
            (string) \Concrete\Core\Url\Url::createFromUrl($canonical)->setPath(\Core::getApplicationRelativePath()),
            (string) $resolver->resolve(array()));

        \Config::set('concrete.seo.canonical_url', $old_value);
    }

    public function testFromRequest()
    {
        $this->markTestIncomplete('This needs to be updated to use the new site-based canonical url');

        $mock = $this->getMock('Concrete\Core\Http\Request');
        $mock->expects($this->once())->method('getScheme')->willReturn('http');
        $mock->expects($this->once())->method('getHost')->willReturn('somehost');

        $resolver = new \Concrete\Core\Url\Resolver\CanonicalUrlResolver(\Core::getFacadeApplication(), $mock);

        $old_value = \Config::get('concrete.seo.canonical_url');
        \Config::set('concrete.seo.canonical_url', null);

        $this->assertEquals(
            (string) \Concrete\Core\Url\Url::createFromUrl("http://somehost")->setPath(\Core::getApplicationRelativePath()),
            (string) $resolver->resolve(array()));

        \Config::set('concrete.seo.canonical_url', $old_value);
    }
}
