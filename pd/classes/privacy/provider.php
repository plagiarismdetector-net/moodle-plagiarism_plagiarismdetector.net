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

/**
 * Privacy Subsystem implementation for plagiarism_pd.
 *
 * @copyright 2025, PlagiarismDetector <support@plagiarismdetector.net>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace plagiarism_pd\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\helper;
use core_privacy\local\request\userlist;
use core_privacy\local\request\writer;

/** Privacy Subsystem implementation for plagiarism_pd. */
/* This plugin does export personal user data.*/
/**
 * provider.php - provider for uses of PlagiarismDetector plugin data.
 *
 * @copyright 2025, PlagiarismDetector <support@plagiarismdetector.net>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements \core_privacy\local\metadata\provider, \core_privacy\local\request\core_userlist_provider, \core_plagiarism\privacy\plagiarism_provider
{
    /* This trait must be included to provide the relevant polyfill for the metadata provider.*/
    use \core_privacy\local\legacy_polyfill;

    /* This trait must be included to provide the relevant polyfill for the plagirism provider.*/
    use \core_plagiarism\privacy\legacy_polyfill;

    /**
     * Returns meta data about this system.
     *
     * @param collection $collection the initialised collection to add items to
     *
     * @return collection a listing of user data stored through this system
     */
    public static function _get_metadata(collection $collection)
    {
        $collection->add_subsystem_link(
            'core_files',
            [],
            'privacy:metadata:core_files'
        );

        $collection->add_database_table(
            'plagiarism_pd_files',
            [
                'userid' => 'privacy:metadata:plagiarism_pd_files:userid',
                'submitter' => 'privacy:metadata:plagiarism_pd_files:submitter',
                'similarityscore' => 'privacy:metadata:plagiarism_pd_files:similarityscore',
                'lastmodified' => 'privacy:metadata:plagiarism_pd_files:lastmodified',
            ],
            'privacy:metadata:plagiarism_pd_files'
        );

        $collection->add_external_location_link('plagiarism_pd_client', [
            'module_id' => 'privacy:metadata:plagiarism_pd_client:module_id',
            'module_name' => 'privacy:metadata:plagiarism_pd_client:module_name',
            'module_type' => 'privacy:metadata:plagiarism_pd_client:module_type',
            'module_creationtime' => 'privacy:metadata:plagiarism_pd_client:module_creationtime',
            'submittion_userId' => 'privacy:metadata:plagiarism_pd_client:submittion_userId',
            'submittion_filename' => 'privacy:metadata:plagiarism_pd_client:submittion_name',
            'submittion_content' => 'privacy:metadata:plagiarism_pd_client:submittion_content',
            'submittion_type' => 'privacy:metadata:plagiarism_pd_client:submittion_type',
        ], 'privacy:metadata:plagiarism_pd_client');

        return $collection;
    }

    /**
     * Get the list of contexts that contain user information for the specified user.
     *
     * @param int $userid the user to search
     *
     * @return contextlist $contextlist  the contextlist containing the list of contexts used in this plugin
     */
    public static function _get_contexts_for_userid($userid)
    {
        $params = [
            'modulename' => 'assign',
            'contextlevel' => CONTEXT_MODULE,
            'userid' => $userid,
        ];

        $sql = 'SELECT ctx.id '.
            'FROM {course_modules} cm '.
            'JOIN {modules} m ON cm.module = m.id AND m.name = :modulename '.
            'JOIN {assign} a ON cm.instance = a.id '.
            'JOIN {context} ctx ON cm.id = ctx.instanceid AND ctx.contextlevel = :contextlevel '.
            'JOIN {plagiarism_pd_files} tf ON tf.cm = cm.id '.
            'WHERE tf.userid = :userid';

        $contextlist = new contextlist();
        $contextlist->add_from_sql($sql, $params);

        return $contextlist;
    }

    /**
     * Export all plagiarism data from each plagiarism plugin for the specified userid and context.
     *
     * @param int      $userid     the user to export
     * @param \context $context    the context to export
     * @param array    $subcontext the subcontext within the context to export this information to
     * @param array    $linkarray  The weird and wonderful link array used to display information for a specific item
     */
    public static function _export_plagiarism_user_data($userid, \context $context, array $subcontext, array $linkarray)
    {
        global $DB;

        if (empty($userid)) {
            return;
        }

        $user = $DB->get_record('user', ['id' => $userid]);

        $params = ['userid' => $user->id];

        $sql = 'SELECT id, submitter, cm, similarityscore, lastmodified '.
            'FROM {plagiarism_pd_files} '.
            'WHERE userid = :userid';
        $submissions = $DB->get_records_sql($sql, $params);

        foreach ($submissions as $submission) {
            $context = \context_module::instance($submission->cm);

            $contextdata = helper::get_context_data($context, $user);

            $contextdata = (object) array_merge((array) $contextdata, $submission);
            writer::with_context($context)->export_data([], $contextdata);

            helper::export_context_files($context, $user);
        }
    }

    /**
     * Delete all data for all users in the specified context.
     *
     * @param \context $context the context to delete in
     */
    public static function _delete_plagiarism_for_context(\context $context)
    {
        global $DB;

        if (empty($context)) {
            return;
        }

        if (!$context instanceof \context_module) {
            return;
        }

        /* Delete all submissions.*/
        $DB->delete_records('plagiarism_pd_files', ['cm' => $context->instanceid]);
    }

    /**
     * Delete all user information for the provided user and context.
     *
     * @param int      $userid  The user to delete
     * @param \context $context the context to refine the deletion
     */
    public static function _delete_plagiarism_for_user($userid, \context $context)
    {
        global $DB;

        if (!$context instanceof \context_module) {
            return;
        }

        $DB->delete_records('plagiarism_pd_files', ['userid' => $userid, 'cm' => $context->instanceid]);
    }

    /**
     * Get a list of users who have data within a context.
     *
     * @param userlist $userlist the userlist containing the list of users who have data in this context/plugin combination
     */
    public static function get_users_in_context(userlist $userlist)
    {
        $context = $userlist->get_context();

        if ($context->contextlevel != CONTEXT_MODULE) {
            return;
        }

        $sql = 'SELECT ptf.userid
                  FROM {plagiarism_pd_files} ptf
                  JOIN {course_modules} c 
                    ON ptf.cm = c.id
                  JOIN {modules} m
                    ON m.id = c.module AND m.name = :modname
                 WHERE c.id = :cmid';

        $params = [
            'modname' => 'plagiarism_pd',
            'cmid' => $context->instanceid,
        ];

        $userlist->add_from_sql('userid', $sql, $params);
    }

    /**
     * Delete data for multiple users within a single context.
     *
     * @param approved_userlist $userlist the approved context and user information to delete information for
     */
    public static function delete_data_for_users(approved_userlist $userlist)
    {
        global $DB;

        $context = $userlist->get_context();

        if ($context->contextlevel != CONTEXT_MODULE) {
            return;
        }

        $userids = $userlist->get_userids();

        list($insql, $inparams) = $DB->get_in_or_equal($userids, SQL_PARAMS_NAMED);

        $sql1 = "SELECT psf.id
                   FROM {plagiarism_pd_files} psf
                   JOIN {course_modules} c 
                     ON psf.cm = c.id
                   JOIN {modules} m 
                     ON m.id = c.module
                  WHERE psf.userid $insql
                    AND c.id = :cmid";

        $params = [
            'cmid' => $context->instanceid,
        ];

        $params = array_merge($params, $inparams);

        $attempt = $DB->get_fieldset_sql($sql1, $params);

        $DB->delete_records_list('plagiarism_pd_files', 'id', array_values($attempt));
    }
}
