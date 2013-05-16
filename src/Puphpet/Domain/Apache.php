<?php

namespace Puphpet\Domain;

use Puphpet\Domain;

class Apache extends Domain
{
    protected $apache;

    public function __construct($apache)
    {
        $this->apache = is_array($apache) ? $apache : array();
    }

    /**
     * Return ready to use Apache array
     *
     * @return array
     */
    public function getFormatted()
    {
        if (empty($this->apache)) {
            return array();
        }

        $this->formatModules()
             ->formatVhosts();

        return $this->apache;
    }

    /**
     * Array of module names
     *
     * @return self
     */
    protected function formatModules()
    {
        $this->apache['modules'] = !empty($this->apache['modules'])
            ? $this->apache['modules']
            : array();

        return $this;
    }

    /**
     * Vhosts to add
     *
     * @return self
     */
    protected function formatVhosts()
    {
        if (empty($this->apache['vhosts'])) {
            return array();
        }

        $vhosts = $this->apache['vhosts'];

        foreach ($vhosts as $id => $vhost) {
            $vhosts[$id]['serveraliases'] = $this->explodeAndQuote($vhosts[$id]['serveraliases']);
            $vhosts[$id]['envvars']       = $this->explodeAndQuote($vhosts[$id]['envvars']);
        }

        $this->apache['vhosts'] = $vhosts;

        return $this;
    }
}
