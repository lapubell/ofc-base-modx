# ofc-base
Basic starting point for a new web project

This is just a shell project that I use to get things started. You'll need the following tools:
- Bower
- Less

I like to use Sublime Text to compile my LESS down to CSS. I don't think I do this the best way, or the easiest way, but I got this to work and so I stuck with it. The first thing that you need to do is have a build system in place on your machine. Mine looks like this:

```
{
    "shell_cmd": "lessc -x --no-color --source-map=$project_path/css/style.css.map $project_path/css/main.less $project_path/css/style.css"
}
```

Go to Tools->Build System->New Build System... and put the above code in. Name it something that makes sense, like LESS Project Build. Now, whenever you want to build your LESS, just hit Ctrl+B (Cmd+B if you're using OSX, Ben).

Now, to get bootstrap, all you have to do is run `bower install` in the project root, and it will grab bootstrap. Then you can run your build and it should be good to go!

Have fun!