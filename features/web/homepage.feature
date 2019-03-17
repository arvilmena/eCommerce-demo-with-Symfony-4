Feature: Homepage
  In order to give idea to users the context of the site
  As a web user
  I need to be able to see Register/Login, or Logout links

  @javascript
  Scenario: Seeing the Register link when unauthenticated
    Given I am on the homepage
    When I am not logged in
    Then I should see "Login"