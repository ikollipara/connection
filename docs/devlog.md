# Development Log

## 2025-09-05

This is the start of a major refactor, one that will transform the conneCTION codebase.
The current plan is to replace nearly the entire frontend with something different, something simpler and streamlined.

The following tables are decomissioned for now:
- `events`
- `days`
- `attendees`
- `views`
- `searches`
- `followers`
- `content_likes`
- `comment_likes`
- `frequently_asked_questions`

### Task List
- [X] Refactor to use `Scope` Attribute
- [ ] Refactor Survey to a Model

## 2025-09-29

I've reconsidered the migration of the metadata to their own tables. For now, I think I'll leave it. The key to get done for Aidan is:
1. Migration to Laravel 12
2. New Interface
3. Improved Codebase Quality

To that end, let's re-examine the task list:
- [X] Migrate to Laravel 12
- [ ] Design new interface for Connection based around searching
- [ ] Refactor old models and designs.

Let's ignore research considerations for a second, and try to redesign connection to use a more search friendly interface.
