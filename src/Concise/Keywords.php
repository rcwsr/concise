<?php

namespace Concise;

class Keywords
{
    public static $defines = array (
  'and' => 'and',
  'between' => 'between',
  'contains' => 'contains',
  'contains_string' => 'contains string',
  'does_not_contain' => 'does not contain',
  'does_not_contain_string' => 'does not contain string',
  'does_not_end_with' => 'does not end with',
  'does_not_equal' => 'does not equal',
  'does_not_equal_file' => 'does not equal file',
  'does_not_exactly_equal' => 'does not exactly equal',
  'does_not_have_item' => 'does not have item',
  'does_not_have_key' => 'does not have key',
  'does_not_have_keys' => 'does not have keys',
  'does_not_have_property' => 'does not have property',
  'does_not_have_value' => 'does not have value',
  'does_not_match_regex' => 'does not match regex',
  'does_not_match_regular_expression' => 'does not match regular expression',
  'does_not_start_with' => 'does not start with',
  'does_not_throw' => 'does not throw',
  'does_not_throw_exception' => 'does not throw exception',
  'doesnt_match_regex' => 'doesnt match regex',
  'doesnt_match_regular_expression' => 'doesnt match regular expression',
  'ends_with' => 'ends with',
  'equals' => 'equals',
  'equals_file' => 'equals file',
  'exactly_equals' => 'exactly equals',
  'false' => 'false',
  'greater_than' => 'greater than',
  'greater_than_or_equal' => 'greater than or equal',
  'gt' => 'gt',
  'gte' => 'gte',
  'has_item' => 'has item',
  'has_items' => 'has items',
  'has_key' => 'has key',
  'has_keys' => 'has keys',
  'has_property' => 'has property',
  'has_value' => 'has value',
  'has_values' => 'has values',
  'ignoring_case' => 'ignoring case',
  'instance_of' => 'instance of',
  'is_a_bool' => 'is a bool',
  'is_a_boolean' => 'is a boolean',
  'is_a_number' => 'is a number',
  'is_a_string' => 'is a string',
  'is_an_array' => 'is an array',
  'is_an_associative_array' => 'is an associative array',
  'is_an_empty_array' => 'is an empty array',
  'is_an_instance_of' => 'is an instance of',
  'is_an_int' => 'is an int',
  'is_an_integer' => 'is an integer',
  'is_an_object' => 'is an object',
  'is_between' => 'is between',
  'is_blank' => 'is blank',
  'is_empty_array' => 'is empty array',
  'is_equal_to' => 'is equal to',
  'is_exactly_equal_to' => 'is exactly equal to',
  'is_false' => 'is false',
  'is_falsy' => 'is falsy',
  'is_greater_than' => 'is greater than',
  'is_greater_than_or_equal_to' => 'is greater than or equal to',
  'is_instance_of' => 'is instance of',
  'is_less_than' => 'is less than',
  'is_less_than_or_equal_to' => 'is less than or equal to',
  'is_not_a_bool' => 'is not a bool',
  'is_not_a_boolean' => 'is not a boolean',
  'is_not_a_number' => 'is not a number',
  'is_not_a_string' => 'is not a string',
  'is_not_an_array' => 'is not an array',
  'is_not_an_associative_array' => 'is not an associative array',
  'is_not_an_empty_array' => 'is not an empty array',
  'is_not_an_instance_of' => 'is not an instance of',
  'is_not_an_int' => 'is not an int',
  'is_not_an_integer' => 'is not an integer',
  'is_not_an_object' => 'is not an object',
  'is_not_between' => 'is not between',
  'is_not_blank' => 'is not blank',
  'is_not_empty_array' => 'is not empty array',
  'is_not_equal_to' => 'is not equal to',
  'is_not_exactly_equal_to' => 'is not exactly equal to',
  'is_not_instance_of' => 'is not instance of',
  'is_not_null' => 'is not null',
  'is_not_numeric' => 'is not numeric',
  'is_not_the_same_as' => 'is not the same as',
  'is_not_unique' => 'is not unique',
  'is_null' => 'is null',
  'is_numeric' => 'is numeric',
  'is_the_same_as' => 'is the same as',
  'is_true' => 'is true',
  'is_truthy' => 'is truthy',
  'is_unique' => 'is unique',
  'less_than' => 'less than',
  'less_than_or_equal' => 'less than or equal',
  'lt' => 'lt',
  'lte' => 'lte',
  'matches_regex' => 'matches regex',
  'matches_regular_expression' => 'matches regular expression',
  'not_between' => 'not between',
  'not_equals' => 'not equals',
  'not_instance_of' => 'not instance of',
  'on_error' => 'on error',
  'starts_with' => 'starts with',
  'throws' => 'throws',
  'throws_anything_except' => 'throws anything except',
  'throws_exactly' => 'throws exactly',
  'throws_exception' => 'throws exception',
  'true' => 'true',
  'with_exact_value' => 'with exact value',
  'with_value' => 'with value',
  'within' => 'within',
);

    public static function load()
    {
        foreach (self::$defines as $k => $v) {
            if (!defined($k)) {
                define($k, $v);
            }
        }
    }
}