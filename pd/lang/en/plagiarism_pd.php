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

$string['pluginname'] = 'PlagiarismDetector Plagiarism Checker';
$string['pdconfig'] = 'PlagiarismDetector Plagiarism Plugin Configuration';
$string['usepd_mod'] = 'Enable PlagiarismDetector for {$a}';
$string['enable'] = 'Enable PlagiarismDetector';
$string['pdexplain'] = 'PlagiarismDetector Plagiarism Checker plugin ';
$string['setting'] = 'Settings';
$string['pdaccountconfig'] = 'PlagiarismDetector Account Configuration';
$string['pdaccountid'] = 'PlagiarismDetector Account ID';
$string['pdpublickey'] = 'PlagiarismDetector Public Key';
$string['pdsecretkey'] = 'PlagiarismDetector Secret Key';
$string['pdapiurl'] = 'PlagiarismDetector API URL';
$string['connecttest'] = 'Test PlagiarismDetector Connection';
$string['pdstatus'] = 'PlagiarismDetector status';
$string['error'] = 'Error Occurred';
$string['pending'] = 'Pending';
$string['queued'] = 'Queued';
$string['success'] = 'Completed Successfully';
$string['complete'] = 'Completed';
$string['similarity'] = 'Similarity';

$string['studentdisclosure'] = 'Student disclosure';
$string['studentdisclosure_help'] = 'This text will be displayed to all students on the file upload page.';
$string['studentdisclosuredefault'] = '<span>By submitting your files you are agreeing to the plagiarism detection service </span><a target="_blank" href="https://plagiarismdetector.net/legal/privacypolicy">privacy policy</a>';
$string['studentdagreedtoeula'] = '<span>You have already agreed to the plagiarism detection service </span><a target="_blank" href="https://plagiarismdetector.net/legal/privacypolicy">privacy policy</a>';

$string['coursesettings'] = 'PlagiarismDetector Settings';
$string['draftsubmit'] = 'Submit files only when students click the submit button';
$string['draftsubmit_help'] = "This option is only available if 'Require students to click the submit button' is Yes";
$string['reportgenspeed'] = 'When to generate report?';
$string['genereportimmediately'] = 'Generate reports immediately';
$string['genereportonduedate'] = 'Generate reports on due date';
$string['allowstudentaccess'] = 'Allow students access to plagiarism reports';
$string['reportpagetitle'] = 'PlagiarismDetector report';
$string['savesuccess'] = 'settings saved successfully!';
$string['pd:enable'] = 'Enable PlagiarismDetector Plagiarism Checker plugin';
$string['pd:viewfullreport'] = 'View Similarity Report';
$string['disabledformodule'] = 'PlagiarismDetector Plagiarism Checker plugin is disabled for this module.';
$string['nopageaccess'] = 'You dont have access to this page.';
$string['openfullscreen'] = 'Open in full screen';
$string['similaritystr'] = 'Similarity Score';
$string['viewreportstr'] = 'View Report';
$string['clickstr'] = 'click here';

$string['updateerror'] = 'Error while trying to update records in database';
$string['inserterror'] = 'Error while trying to insert records to database';

$string['digital_receipt_subject'] = 'PlagiarismDetector Digital Receipt';
$string['digital_receipt_message'] = 'Dear {$a->firstname} {$a->lastname},<br /><br />You have successfully submitted the file <strong>{$a->submission_title}</strong> to the assignment <strong>{$a->assignment_name}{$a->assignment_part}</strong> in the class <strong>{$a->course_fullname}</strong> on <strong>{$a->submission_date}</strong>. Your full digital receipt can be viewed and printed from the print/download button in the Document Viewer.<br /><br />Thank you for using PlagiarismDetector,<br /><br />The PlagiarismDetector Team';

$string['errorcode0'] = 'This file has not been submitted to PlagiarismDetector, please consult your system administrator';
$string['errorcode1'] = 'This file has not been sent to PlagiarismDetector as it does not have enough content to produce a Similarity Report.';
$string['errorcode2'] = 'This file will not be submitted to PlagiarismDetector as it exceeds the maximum size of {$a->maxfilesize} allowed';
$string['errorcode3'] = 'This file has not been submitted to PlagiarismDetector because the user has not accepted the PlagiarismDetector End User Licence Agreement.';
$string['errorcode4'] = 'You must upload a supported file type for this assignment. Accepted file types are; .doc, .docx, .ppt, .pptx, .pps, .ppsx, .pdf, .txt, .htm, .html, .hwp, .odt, .wpd, .ps and .rtf';
$string['errorcode5'] = 'This file has not been submitted to PlagiarismDetector because there is a problem creating the module in PlagiarismDetector which is preventing submissions, please consult your API logs for further information';
$string['errorcode6'] = 'This file has not been submitted to PlagiarismDetector because there is a problem editing the module settings in PlagiarismDetector which is preventing submissions, please consult your API logs for further information';
$string['errorcode7'] = 'This file has not been submitted to PlagiarismDetector because there is a problem creating the user in PlagiarismDetector which is preventing submissions, please consult your API logs for further information';
$string['errorcode8'] = 'This file has not been submitted to PlagiarismDetector because there is a problem creating the temp file. The most likely cause is an invalid file name. Please rename the file and re-upload using Edit Submission.';
$string['errorcode9'] = 'The file cannot be submitted as there is no accessible content in the file pool to submit.';
$string['errorcode10'] = 'This file has not been submitted to PlagiarismDetector because there is a problem creating the class in PlagiarismDetector which is preventing submissions, please consult your API logs for further information';
$string['errorcode11'] = 'This file has not been submitted to PlagiarismDetector because it is missing data';
$string['errorcode12'] = 'This file has not been submitted to PlagiarismDetector because it belongs to an assignment in which the course was deleted. Row ID: ({$a->id}) | Course Module ID: ({$a->cm}) | User ID: ({$a->userid})';
$string['errorcode14'] = 'This file has not been submitted to PlagiarismDetector because the attempt it belongs to could not be found';

$string['updatereportscores'] = 'Update Report Scores for PlagiarismDetector Plagiarism Plugin';
$string['sendqueuedsubmissions'] = 'Send Queued Files from the PlagiarismDetector Plagiarism Plugin';

$string['coursegeterror'] = 'Could not get course data';
$string['cronsubmittedsuccessfully'] = 'Submission: {$a->title} ( ID: {$a->submissionid}) for the assignment {$a->assignmentname} on the course {$a->coursename} was successfully submitted to PlagiarismDetector.';

$string['messageprovider:submission'] = 'PlagiarismDetector Plagiarism Plugin Digital Receipt notifications';

$string['report_title'] = 'PlagiarismDetector Report';

$string['privacy:metadata:core_files'] = 'PlagiarismDetector stores files that have been uploaded to Moodle to form a PlagiarismDetector submission.';
$string['privacy:metadata:plagiarism_pd_files'] = 'Information that links a Moodle submission to a PlagiarismDetector submission.';
$string['privacy:metadata:plagiarism_pd_files:userid'] = 'The ID of the user who is the owner of the submission.';
$string['privacy:metadata:plagiarism_pd_files:submitter'] = 'The ID of the user who has made the submission.';
$string['privacy:metadata:plagiarism_pd_files:similarityscore'] = 'The similarity score of the submission.';
$string['privacy:metadata:plagiarism_pd_files:lastmodified'] = 'A timestamp indicating when the user last modified their submission.';
$string['privacy:metadata:plagiarism_pd_client'] = 'In order to integrate with a PlagiarismDetector, some user data needs to be exchanged with PlagiarismDetector.';
$string['privacy:metadata:plagiarism_pd_client:module_id'] = 'The module id is sent to PlagiarismDetector for identification purposes.';
$string['privacy:metadata:plagiarism_pd_client:module_name'] = 'The module name is sent to PlagiarismDetector for identification purposes.';
$string['privacy:metadata:plagiarism_pd_client:module_type'] = 'The module type is sent to PlagiarismDetector for identification purposes.';
$string['privacy:metadata:plagiarism_pd_client:module_creationtime'] = 'The module creation time is sent to PlagiarismDetector for identification purposes.';
$string['privacy:metadata:plagiarism_pd_client:submittion_userId'] = 'The submission userId is sent to PlagiarismDetector for identification purposes.';
$string['privacy:metadata:plagiarism_pd_client:submittion_name'] = 'The submission name is sent to PlagiarismDetector for identification purposes.';
$string['privacy:metadata:plagiarism_pd_client:submittion_type'] = 'The submission type is sent to PlagiarismDetector for identification purposes.';
$string['privacy:metadata:plagiarism_pd_client:submittion_content'] = 'The submission content is sent to PlagiarismDetector for scan processing.';
