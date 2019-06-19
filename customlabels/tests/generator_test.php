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
 * PHPUnit customlabels generator tests
 *
 * @package    mod_customlabels
 * @category   phpunit
 * @copyright  2013 Jerome Mouneyrac
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


/**
 * PHPUnit customlabels generator testcase
 *
 * @package    mod_customlabels
 * @category   phpunit
 * @copyright  2013 Jerome Mouneyrac
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_customlabels_generator_testcase extends advanced_testcase {
    public function test_generator() {
        global $DB;

        $this->resetAfterTest(true);

        $this->assertEquals(0, $DB->count_records('customlabels'));

        $course = $this->getDataGenerator()->create_course();

        /** @var mod_customlabels_generator $generator */
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_customlabels');
        $this->assertInstanceOf('mod_customlabels_generator', $generator);
        $this->assertEquals('customlabels', $generator->get_modulename());

        $generator->create_instance(array('course'=>$course->id));
        $generator->create_instance(array('course'=>$course->id));
        $customlabels = $generator->create_instance(array('course'=>$course->id));
        $this->assertEquals(3, $DB->count_records('customlabels'));

        $cm = get_coursemodule_from_instance('customlabels', $customlabels->id);
        $this->assertEquals($customlabels->id, $cm->instance);
        $this->assertEquals('customlabels', $cm->modname);
        $this->assertEquals($course->id, $cm->course);

        $context = context_module::instance($cm->id);
        $this->assertEquals($customlabels->cmid, $context->instanceid);
    }
}
