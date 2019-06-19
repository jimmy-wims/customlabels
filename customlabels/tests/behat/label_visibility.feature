@mod @mod_customlabels

Feature: Check customlabels visibility works
  In order to check customlabels visibility works
  As a teacher
  I should create customlabels activity

  @javascript
  Scenario: Hidden customlabels activity should be show as hidden.
    Given the following "courses" exist:
      | fullname | shortname | category |
      | Test | C1 | 0 |
    And the following "users" exist:
      | username | firstname | lastname | email |
      | teacher | Teacher | Frist | teacher1@example.com |
      | student | Student | First | student1@example.com |
    And the following "course enrolments" exist:
      | user | course | role |
      | teacher | C1 | editingteacher |
      | student | C1 | student |
    Given I log in as "teacher"
    And I am on "Test" course homepage with editing mode on
    When I add a "customlabels" to section "1" and I fill the form with:
      | Label text | Swanky customlabels |
      | Availability | Hide from students |
    Then "Swanky customlabels" activity should be hidden
    And I turn editing mode off
    And "Swanky customlabels" activity should be hidden
    And I log out
    And I log in as "student"
    And I am on "Test" course homepage
    And I should not see "Swanky customlabels"
    And I log out

  @javascript
  Scenario: Visible customlabels activity should be shown as visible.
    Given the following "courses" exist:
      | fullname | shortname | category |
      | Test | C1 | 0 |
    And the following "users" exist:
      | username | firstname | lastname | email |
      | teacher | Teacher | Frist | teacher1@example.com |
      | student | Student | First | student1@example.com |
    And the following "course enrolments" exist:
      | user | course | role |
      | teacher | C1 | editingteacher |
      | student | C1 | student |
    Given I log in as "teacher"
    And I am on "Test" course homepage with editing mode on
    When I add a "customlabels" to section "1" and I fill the form with:
      | Label text | Swanky customlabels |
      | Availability | Show on course page |
    Then "Swanky customlabels" activity should be visible
    And I log out
    And I log in as "student"
    And I am on "Test" course homepage
    And "Swanky customlabels" activity should be visible
    And I log out

  @javascript
  Scenario: Teacher can not show customlabels inside the hidden section
    Given the following "courses" exist:
      | fullname | shortname | category |
      | Test | C1 | 0 |
    And the following "users" exist:
      | username | firstname | lastname | email |
      | teacher | Teacher | Frist | teacher1@example.com |
      | student | Student | First | student1@example.com |
    And the following "course enrolments" exist:
      | user | course | role |
      | teacher | C1 | editingteacher |
      | student | C1 | student |
    Given I log in as "teacher"
    And I am on "Test" course homepage with editing mode on
    When I add a "customlabels" to section "1" and I fill the form with:
      | Label text | Swanky customlabels |
      | Availability | Show on course page |
    And I hide section "1"
    Then "Swanky customlabels" activity should be dimmed
    And I open "Swanky customlabels" actions menu
    And "Swanky customlabels" actions menu should not have "Show" item
    And "Swanky customlabels" actions menu should not have "Hide" item
    And "Swanky customlabels" actions menu should not have "Make available" item
    And "Swanky customlabels" actions menu should not have "Make unavailable" item
    And I click on "Edit settings" "link" in the "Swanky customlabels" activity
    And I expand all fieldsets
    And the "Availability" select box should contain "Hide from students"
    And the "Availability" select box should not contain "Make available but not shown on course page"
    And the "Availability" select box should not contain "Show on course page"
    And I log out
    And I log in as "student"
    And I am on "Test" course homepage
    And I should not see "Swanky customlabels"
    And I log out
