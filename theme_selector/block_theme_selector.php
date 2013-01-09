<?php

class block_theme_selector extends block_base
{
    public function init()
    {
        $this->title = 'Theme selector';
    }

    public function hide_header()
    {
        return true;
    }

    public function get_content()
    {
        if ($this->content !== null) {
            return $this->content;
        }

        global $COURSE;
        $coursecontext = context_course::instance($COURSE->id);
        $this->content = new stdClass();
        $this->content->text = '';
        $this->page->requires->js('/blocks/theme_selector/theme-selector.js');

        if (has_capability('moodle/site:config', $coursecontext)) {
            // Add a dropdown to switch themes
            $themes = get_plugin_list('theme');
            $options = array_combine(array_keys($themes), array_keys($themes));
            $select = html_writer::select($options, 'choose', get_selected_theme_for_device_type('default'), false, array('data-sesskey' => sesskey(), 'data-device' => 'default'));
            $this->content->text .= 'Change theme: ' . $select;

            $this->content->text .= '<br />';
            $this->content->text .= '<br />';

            // Add a button to reset theme caches
            $this->content->text .= html_writer::start_tag('form', array('action' => new moodle_url('theme/index.php'), 'method' => 'post'));
            $this->content->text .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'sesskey', 'value' => sesskey()));
            $this->content->text .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'reset', 'value' => '1'));
            $this->content->text .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'device', 'value' => 'default'));
            $this->content->text .= html_writer::tag('button', 'Reset theme cache', array('type' => 'submit'));
            $this->content->text .= html_writer::end_tag('form');

            $this->content->text .= '<br />';
        }

        return $this->content;
    }
}