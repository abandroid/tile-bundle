Feature: Generate tile via URL

  Scenario: Visiting URL
    Given I am on "/tile/test.png"
    Then the response status code should be 200
    And I should see "image/png" in the header "content-type"