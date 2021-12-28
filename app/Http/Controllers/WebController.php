<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Traits\SEOTools;

abstract class WebController extends Controller
{
    use SEOTools;

    /**
     * @var string
     */
    protected string $metaTitleSuffix;

    /**
     * WebController constructor.
     */
    public function __construct()
    {
        $appName = strval(config('app.name'));

        $this->metaTitleSuffix(config('seotools.meta.defaults.separator') . $appName);
        $this->metaTitle($appName, false);
        $this->metaRobotsDeny();
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    protected function metaDescription(string $description): self
    {
        $this->seo()->setDescription($description);

        return $this;
    }

    /**
     * @param string $suffix
     *
     * @return $this
     */
    protected function metaTitleSuffix(string $suffix): self
    {
        $this->metaTitleSuffix = $suffix;

        return $this;
    }

    /**
     * @param string $title
     * @param bool $useSuffix
     *
     * @return $this
     */
    protected function metaTitle(string $title, bool $useSuffix = true): self
    {
        $setTitle = trim($title);

        if ($useSuffix) {
            $setTitle .= $this->metaTitleSuffix;
        }

        if (config('app.debug')) {
            $env = strval(config('app.env'));
            $setTitle = '[' . strtoupper($env) . '] ' . $setTitle;
        }

        $this->seo()->metatags()->setTitle($setTitle);

        return $this;
    }

    /**
     * @return $this
     */
    protected function metaRobotsAllow(): self
    {
        return $this->metaRobots('index, follow');
    }

    /**
     * @return $this
     */
    protected function metaRobotsDeny(): self
    {
        return $this->metaRobots('noindex, follow');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    private function metaRobots(string $value): self
    {
        $this->seo()->metatags()->addMeta('robots', $value);

        return $this;
    }
}
