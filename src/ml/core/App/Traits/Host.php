<?php


trait Masteryl_App_Host
{
    public function activate()
    {
        // ee('activate');
        if (!isset($this->_host)) {
            $this->loadHost();
        }

        $this->_host->onActivate();
    }

    public function host()
    {
        if (!isset($this->_host)) {
            $this->loadHost();
        }

        return $this->_host;
    }
  
    public function deactivate()
    {
        if (!isset($this->_host)) {
            $this->loadHost();
        }

        $this->_host->onDeactivate();
    }


    private function loadHost()
    {
        $this->_host = new Masteryl_Host($this);
    }
}
