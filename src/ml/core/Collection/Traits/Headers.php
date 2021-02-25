<?php

trait Masteryl_Collection_Headers
{
    public function getAssociateTableHeaders()
    {
        $method = $this->getAssociateMethodName('get', 'TableHeaders');

        // echo $method;exit;

        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        return $this->_getHeaders();
    }

    protected function getTableHeaders()
    {
        return $this->getHeaders();
    }

    public function getHeaders()
    {
        return $this->_getHeaders();
    }

    private function _getHeaders()
    {
        $headers = [];

        // masteryl_send_json($this->fills);
        $fills = $this->fills;
        array_push($fills, 'id');

        $c = 0;
        foreach ($fills as $i) {
            if (!empty($this->hidden) && in_array($i, $this->hidden, true)) {
                continue;
            }

            $headers[$c] = [
                'text' => $this->keyToHeader($i),
                'value' => $i,
            ];

            if ($this->can_edit) {
                $headers[$c]['editable'] = !in_array($i, ['id', 'identifier'], true);
            }
            $c++;
        }

        if ($this->timestamps) {
            $headers[] = [
                'text' => 'Created',
                'value' => 'created',
            ];
        }

        if ($this->timestamps) {
            $headers[] = [
                'text' => 'Updated',
                'value' => 'updated',
            ];
        }

        return $headers;
    }

    private function keyToHeader($key)
    {
        return ucwords(str_replace('_', ' ', $key));
    }
}
