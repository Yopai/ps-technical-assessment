# Formal definition of language

    statements :: statement | statement statements

    statement :: loop_statement | assignment | valuated_expression

    loop_statement :: foreach_statement

    foreach_statement :: FOREACH variable IN valuated_expression statements NEXT

    valuated_expression :: bracketed_expression | single_expression

    single_expression :: left_part | left_part + right_part

    right_part :: PIPE_OPERATOR + ( select_operator | range_operator | keyword_operator

    select_operator :: ordinal_expression

    range_operator :: full_range_operator | end_range_operator
    full_range_operator :: ordinal_expression + RANGE_OPERATOR + ordinal_expression?
    end_range_perator :: RANGE_OPERATOR + ordinal_expression

    keyword_operator :: WORDS | COUNT

    left_part :: variable

    assignment :: SET variable valuated_expression

    ordinal_expression :: znumber | bracketed_expression

    znumber :: MINUS? + nnumber

    nnumber :: DIGIT | DIGIT + nnumber

    bracketed_expression :: '(' valuated_expression ')'

    variable :: first_identifier_char identifier_tail
    first_identifier_char :: LETTER | UNDERSCORE
    any_identifier_char :: LETTER | UNDERSCORE | DIGIT
    identifier_tail :: any_identifier_char | any_identifier_char identifier_tail

FOREACH :: 'foreach'
IN :: 'in'
PIPE_OPERATOR :: ':'
RANGE_OPERATOR :: '..'
ASSIGNMENT :: '='
MINUS :: '-'
DIGIT :: '0'..'9'
WORDS :: 'words'
COUNT :: 'count'
NEXT :: 'next'
LETTER :: 'A'..'Z' | 'a'..'z'
UNDERSCORE :: '_'
SET :: 'set'

# Structures and keywords

When a list-operator is applied on a string, :chars is implied

## foreach
    foreach <var> in <list>
        expression(s)
    next

The value of the foreach loop is the concatenation of evaluation of the expressions for each item of &lt;list>

    <list>:<n> >> <string|list>
Select only the <n>th element from the list

    <list>:[start]..[end] >> <list>
Select only items from the given range

start can be omitted and defaults to 1.

start and end can be negative, in which case it means "the (length-|start|+1)th element"; in particular, -1 means the last element
end can be omitted, defaults to -1 (i.e., the last element)

    <string>:chars >> <list>
Split &lt;string&gt; into chars

    <string>:words >> <list>
Split &lt;string&gt; into words

    set var expression
Affect the result of expression to _var_

# Samples
    foreach input in inputs:1..5
        input|words:
    next
