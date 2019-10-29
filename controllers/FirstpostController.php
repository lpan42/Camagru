<?php
class FirstpostController extends Controller
{
    public function process($args)
    {
        $this->head['title'] = 'My Gallery';
        // Sets the template
        $this->view = 'firstpost';
    }
}
?>