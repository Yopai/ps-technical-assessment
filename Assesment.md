# Concepts
In order to create the requested API, it requests an expression parser, which means :
- the choice and definition of a formal language
- the implementation of the corresponding tokenizer
- the implementation of the corresponding evaluator

I made the code of this repo in a few couple of hours (at a glance, 6 - 10 hours), when I happened to find the time to think of it and code some classes.

# Thoughts and criticism
As ever, some things are clearer once you've done them. Particularly when you think you have a limited time to do it :)

## On my knowledge
I've quickly setup the required docker-compose file, although I only have done them with apache-php altogether and http.
It allowed me to confirm that you just have to know what you put in the docker.

I created a swagger, but I think I didn't manipulate enough to enjoy all of its power. In particular, it seems to result in a 403 error - whereas the request is allowed in the browser.

## On the method
I made the API delivered by a Symfony (as it was the quickest for me to install).
Given the fact it was not required to be fully implemented, it would have been preferable to focus
on a clear language definition, and write tests first. But writing a parser was a good challenge,
I couldn't resist it ;)

## On the language
Given the purpose of this language, which is just a transformation language from a string into a string, I realized
afterwards that a templating language should have been preferred. A twig-like language would have been nicer to use,
so you could write something like :

    {% foreach input1|splitwords as word %}{{ word|chars(1) }}{% endfor %}
    .
    {% if input2|splitwords|count > 1 %}
        {% foreach input2|words|range(1,-1) as word %}{{ word|chars(1) }}{% endfor %}
        {{ input2|words|range(-1) }}
    {% else %}
        {{ input2 }}
    {% endif %}
    @{{ input3 }}.{{ input4 }}.{{ input5 }}

In fact, using the Twig engine itself, with a restricted set of filters, would have been a good option, with only two caveats :
- as the purpose is to generate an email address, spaces should be fully ignored
- the result of any {{ }} evaluation must be automatically filtered for chars

I decided (as much in the formal language as in the twig-like sample above) not to have something specific for "the first char of each word",
preferring an explicit foreach loop; however, given the high usability of such a function, a shortcut would probably have been an idea.

## On what is done and what is missing
- The tokenizer should be fine (although it have not been extensively tested)
- The interpreter class is to be implemented, resolving Evaluations all along.
- the Swagger has been set up quickly and

## On the use of eval
Using eval would have been a security hole, because it will allow access to system functions.
We can note it could be partially, and maybe fully) mitigated :
- by using built-in mechanisms (for php : disabled_functions, safer eval - http://evileval.sourceforge.net/)
- by using the interpretor of another language in some sandbox (some javascript interpreter with the
    restrictions applying to a web script)
- by using a language that has no external effect, such xpath expressions
A good answer to the probleme would therefore be to evaluate these solutions before writing a parser.
