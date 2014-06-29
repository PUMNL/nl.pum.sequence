nl.pum.sequence
===============

CiviCRM extension to add sequence functionality (similar to Oracle sequences) to the API.


Usage:
------

API entity "Sequence"
- Action "Create"
  Mandatory Parameters: name
  Optional parameters: increment (default 1), min_value (default 1), max_value (default 18446744073709551615), cur_value (default 1), cycle (default 0)
  Return value: n.a.
- Action "Nextval"
  Mandatory Parameters: name
  Mandatory Parameters: n.a.
  Return value: number


Background / conditions:
------------------------

Sequences are recorded in table civicrm_pum_sequence
All numbers are bigint(20), unsigned
Nextval returns the value stored in column "cur_value", before it is raised and stored
If cur_value is gets of bounds (min_value - max_value), it is set to min_value (after raising), but only if cycle is set to TRUE (1).
If cycle is not set to TRUE (1), Nextval will continuously return cur_value once it has reached max_value.
As increment is unsigned, there is no support for negative increments.
There is no verification, on e.g.
- min_value <= cur_value <= max_value
- sensible increment
