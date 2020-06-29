# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0-alpha] - 2020-06-29
### Changed
- The twig functions has been renamed to align with the method names in the tag bag library.
    - `setono_tag_bag_head_tags` renamed to `setono_tag_bag_render_head`
    - `setono_tag_bag_body_begin_tags` renamed to `setono_tag_bag_render_body_begin`
    - `setono_tag_bag_body_end_tags` renamed to `setono_tag_bag_render_body_end`
    - `setono_tag_bag_tags` without arguments renamed to `setono_tag_bag_render_all`
    - `setono_tag_bag_tags` with arguments renamed to `setono_tag_bag_render_section`. Notice that `setono_tag_bag_render_section`
    only accepts one argument (the section) now.

### Removed
- The actual implementation of the tag bag has been extracted to a [separate library](https://github.com/Setono/tag-bag)
and hence removed from this bundle. This also includes the Twig tag implementation, which has been moved to 
[this library](https://github.com/Setono/tag-bag-twig).
