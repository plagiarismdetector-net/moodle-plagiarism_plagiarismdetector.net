<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/*
 * @package   plagiarism_pd
 * @copyright 2025, PlagiarismDetector <support@plagiarismdetector.net>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once $CFG->dirroot.'/plagiarism/pd/lib.php';
require_once $CFG->libdir.'/formslib.php';

class pd_setupform extends moodleform
{
    // Define the form.
    public function definition()
    {
        global $DB, $CFG;

        $mform = $this->_form;

        $mform->disable_form_change_checker();

        $mform->addElement('header', 'config', get_string('pdconfig', 'plagiarism_pd'));
        $mform->addElement('html', get_string('pdexplain', 'plagiarism_pd').'</br></br>');

        // Loop through all modules that support Plagiarism.
        $mods = array_keys(core_component::get_plugin_list('mod'));

        foreach ($mods as $mod) {
            if (plugin_supports('mod', $mod, FEATURE_PLAGIARISM)) {
                $mform->addElement('advcheckbox',
                    'plagiarism_pd_mod_'.$mod,
                    get_string('usepd_mod', 'plagiarism_pd', ucfirst($mod)),
                    '',
                    null,
                    [0, 1]
                );
            }
        }

        $mform->addElement(
            'textarea',
            'plagiarism_pd_studentdisclosure',
            get_string('studentdisclosure', 'plagiarism_pd')
        );
        $mform->addHelpButton(
            'plagiarism_pd_studentdisclosure',
            'studentdisclosure',
            'plagiarism_pd'
        );

        $mform->addElement('header', 'plagiarism_pdconfig', get_string('pdaccountconfig', 'plagiarism_pd'));
        $mform->setExpanded('plagiarism_pdconfig');

        $mform->addElement('text', 'plagiarism_pd_publickey', get_string('pdpublickey', 'plagiarism_pd'));
        $mform->setType('plagiarism_pd_publickey', PARAM_TEXT);
        $mform->addElement('passwordunmask', 'plagiarism_pd_secretkey', get_string('pdsecretkey', 'plagiarism_pd'));

        $this->add_action_buttons();
    }

    /**
     * Display the form, saving the contents of the output buffer overriding Moodle's
     * display function that prints to screen when called.
     *
     * @return the form as an object to print to screen at our convenience
     */
    public function display()
    {
        ob_start();
        parent::display();
        $form = ob_get_contents();
        ob_end_clean();

        return $form;
    }

    /**
     * Save the plugin config data.
     */
    public function save($data)
    {
        global $CFG;
        global $DB;

        // Save whether the plugin is enabled for individual modules.
        $mods = array_keys(core_component::get_plugin_list('mod'));
        $pluginenabled = 0;
        foreach ($mods as $mod) {
            if (plugin_supports('mod', $mod, FEATURE_PLAGIARISM)) {
                $property = 'plagiarism_pd_mod_'.$mod;
                ${ 'plagiarism_pd_mod_'."$mod" } = (!empty($data->$property)) ? $data->$property : 0;
                set_config('plagiarism_pd_mod_'.$mod, ${ 'plagiarism_pd_mod_'."$mod" }, 'plagiarism_pd');
                if (${ 'plagiarism_pd_mod_'."$mod" }) {
                    $pluginenabled = 1;
                }
            }
        }

        // save whether plugin is enabled or not in DB
        $defaultfield = new stdClass();
        $defaultfield->name = 'plagiarism_pd_enable';
        $defaultfield->value = $pluginenabled;
        $id = $DB->get_field('plagiarism_pd_config', 'id', (['cm' => null, 'name' => 'plagiarism_pd_enable']));
        if ($id) {
            $defaultfield->id = $id;
            $DB->update_record('plagiarism_pd_config', $defaultfield);
        } else {
            $DB->insert_record('plagiarism_pd_config', $defaultfield);
        }

        // misc configs
        set_config('enabled', $pluginenabled, 'plagiarism_pd');
        // TODO: Remove pd_use completely when support for 3.8 is dropped.
        if ($CFG->branch < 39) {
            set_config('pd_use', $pluginenabled, 'plagiarism');
        }
        $properties = ['publickey', 'secretkey', 'studentdisclosure'];

        foreach ($properties as $property) {
            $property = 'plagiarism_pd_'.$property;
            set_config($property, $data->$property, 'plagiarism_pd');
        }
    }
}
