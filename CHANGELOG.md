# Changelog

## 1.1.4
- Move `.hogan-links-item` class to filter default. [#16](https://github.com/DekodeInteraktiv/hogan-links/pull/16)

## 1.1.3
- Update module to new registration method introduced in [Hogan Core 1.1.7](https://github.com/DekodeInteraktiv/hogan-core/releases/tag/1.1.7)
- Set hogan-core dependency `"dekodeinteraktiv/hogan-core": ">=1.1.7"`
- Add Dekode Coding Standards.

## 1.1.2
- Set link text if not set in WP link picker

## 1.1.1
- Added default classname to the `<ul>` and `<li>` elements
- Added `hogan_links_after_text` after text action.

## 1.1.0
### Breaking Changes
- Remove heading field, provided from Core in [#53](https://github.com/DekodeInteraktiv/hogan-core/pull/53)
- Heading field has to be added using filter (was default on before).
