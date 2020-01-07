# General notes
When logging time, always add ticket key and title. Add extra comment
when needed.
# GIT and ticket flow
Create technical tickets based on initial story "Create technical tickets"
task ticket  and start resolving them as you see fit.
Create branch based on story or epic when a ticket has one otherwise create
on ticket key.
When a commit is needed by separate tickets consider committing directly to
master branch. You can also squash merge finished story to master when app is not in
production yet.
Commit often with logical steps (also inside ticket) and add ticket key
and message describing the commit.
# Set up Environments

## Config repositories
Commit `config/local.json` and `.env.local` to separate config repositories so that
they are usable with command
`git archive --format=tar local
--remote ssh://git@domain/path-to-configs
| tar xf -` where `local` reflecting the branch and environment it
should be used in.

## Vue Storefront
Clone VS from Github and keep the history.
> **Note:** For this assignment use Vue Storefront demo as a backend.

## Symfony
See [Documentation/Symfony](Documentation/Symfony.md)

## Windows user
Use Linux with [Windows Subsystem for Linux](https://docs.microsoft.com/en-us/windows/wsl/install-win10)

# Coding
## API
Make unit test for controller and do not extend Symfony abstract
controller.
Make functional test for (do not have to be success request) api route.
See
[Documentation/ControllerExample.php](Documentation/ControllerExample.php)
and
[Documentation/TestExample.php](Documentation/TestExample.php).

### Fetch
[Fetch](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API) is the new API for fetching resources. For the beginner can cause
problems a difference witch is hard do notice at first - it makes
preceding
[OPTIONS request](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/OPTIONS)
witch you must also provide when making API
resources.

## Sonata admin
See [Documentation/SonataAdmin](Documentation/SonataAdmin.md)
