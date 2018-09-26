@wip
Feature: Playing mastermind
  As a code breaker
  I want to practice breaking codes
  In order to have fun

  Background:
    Given a decoding board of 12 attempts

  Scenario Outline: Making a guess
    Given the code maker placed the "<Pattern>" pattern on the board
    When I try to break the code with "<Guess>"
    Then the code maker should give me "<Feedback>" feedback on my guess
    Examples:
      # Feedback legend:
      # X - Correct colour and position
      # O - Correct colour but wrong position
      | Pattern               | Guess                       | Feedback |
      | Red Green Blue Yellow | Red Purple Purple Purple    | X        |
      | Red Green Blue Yellow | Purple Purple Purple Purple |          |
      | Red Green Blue Yellow | Purple Red Purple Purple    | O        |
      | Red Green Blue Yellow | Red Purple Green Purple     | X O      |
      | Red Green Blue Yellow | Red Green Blue Purple       | X X X    |
      | Red Green Blue Yellow | Red Yellow Blue Green       | X X O O  |
      | Red Green Blue Yellow | Yellow Blue Green Red       | O O O O  |
      | Red Green Blue Yellow | Red Green Blue Yellow       | X X X X  |
      | Red Green Blue Yellow | Red Red Red Purple          | X        |
      | Green Red Blue Yellow | Green Yellow Red Blue       | X O O O  |
      | Green Red Blue Yellow | Red Green Yellow Blue       | O O O O  |
      | Green Red Blue Yellow | Green Red Yellow Blue       | X X O O  |
      | Red Green Red Yellow  | Red Red Purple Purple       | X O      |
      | Red Red Red Yellow    | Red Green Purple Purple     | X        |
      | Red Red Blue Yellow   | Purple Purple Red Purple    | O        |
      | Red Blue Blue Yellow  | Purple Purple Red Red       | O        |

  Scenario: Winning a game
    Given the code maker placed the "Red Green Blue Yellow" pattern on the board
    When I try to break the code with an invalid pattern 11 times
    But I break the code in the final guess
    Then I should win the game

  Scenario: Loosing a game
    Given the code maker placed the "Red Green Blue Yellow" pattern on the board
    When I try to break the code with an invalid pattern 12 times
    Then I should loose the game
