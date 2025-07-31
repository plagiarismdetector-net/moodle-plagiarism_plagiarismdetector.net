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

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');   ///  It must be included from a Moodle page
}

// Constants.
const plagiarism_pd_max_file_upload_size = 104857600;
const plagiarism_pd_cron_submissions_limit = 100;
const accepted_pd_file_exts = ['.doc', '.docx', '.ppt', '.pptx', '.pps', '.ppsx',
    '.pdf', '.txt', '.htm', '.html', '.hwp', '.odt',
    '.wpd', '.ps', '.rtf', '.xls', '.xlsx', ];
const plagiarism_pd_api_base_url = 'https://plagiarismdetector.net/api';
const plagiarism_pd_pending_status = 'pending';
const plagiarism_pd_queued_status = 'queued';
