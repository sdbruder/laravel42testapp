
- The contact search was implemented using MySQL 5.6's Full text search in
  Boolean mode and it have its advantages and disadvantages, a simpler LIKE will
  have more predictable behaviour but will lack in performance in large scale
  environments. If the LIKE search is preferable its a simple and fast change.

