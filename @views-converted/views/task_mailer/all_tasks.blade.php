@if (!(@comment.blank? ))
{{ @comment }}

@end
= Doing ===============
@foreach (@tasks[:doing_tasks] as t)
- {{ strip_tags t.msg_without_book_name }}
@end

= TodoHigh ===========
@foreach (@tasks[:todo_high_tasks] as t)
- {{ strip_tags t.msg_without_book_name }}
@end

= TodoMid ============
@foreach (@tasks[:todo_mid_tasks] as t)
- {{ strip_tags t.msg_without_book_name }}
@end

= TodoLow ============
@foreach (@tasks[:todo_low_tasks] as t)
- {{ strip_tags t.msg_without_book_name }}
@end

= Waiting ============
@foreach (@tasks[:waiting_tasks] as t)
- {{ strip_tags t.msg_without_book_name }}
@end
