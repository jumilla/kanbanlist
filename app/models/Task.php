<?php

class Task extends Eloquent
{
    public $status_table = [
        'todo_h' => 0,
        'todo_m' => 1,
        'todo_l' => 2,
        'doing' => 3,
        'waiting' => 4,
        'done' => 5,
    ];
    public $book_name_patterns = [
        '/^\[(.+?)\][ ]*/)',
        '/^【(.+?)】[ ]*/)',
    ];

    public function user()
    {
        $this->hasOne('User');
    }

    public function book()
    {
        $this->hasOne('Book');
    }

    public function scope_by_name_and_status($query, $name, $status)
    {
        //where(:name => name, :status => @@status_table[status])
    }

    public function scope_by_status($query, $status)
    {
        //where(:status => @@status_table[status]).order("order_no ASC, updated_at DESC")
    }

    public function scope_by_status_and_filter($query, $status, $filter)
    {
        //where("status = ? and msg LIKE ?", @@status_table[status] , "%#{URI.decode(filter)}%").order('order_no ASC, updated_at DESC')
    }

    public function scope_filtered($query, $name, $filter)
    {
        //where("name = ? and msg LIKE ?", name ,"%#{URI.encode(filter)}%").order('order_no ASC, updated_at DESC')
    }

    public function scope_done($query)
    {
        //where(:status => @@status_table[:done]).order('updated_at DESC');
    }

    public function scope_done_and_filter($query, $filter)
    {
        //where("status = ? and msg LIKE ?", @@status_table[:done] , "%#{URI.decode(filter)}%").order('updated_at DESC')
    }

    public function scope_today_done($query)
    {
        //where("status = ? and updated_at LIKE ?", @@status_table[:done], "#{Time.now.strftime("%Y-%m-%d")}%").order('updated_at DESC' )
    }

    public function scope_select_month($query)
    {
        //$select_mon;
//        where(" updated_at >= ? and updated_at < ? ", select_mon, select_mon + 1.month )
    }

    public function scope_newest_add($query)
    {
//        where("status != ?", @@status_table[:done]).order('created_at DESC' ).limit(10);
    }

    public function scope_newest_done($query)
    {
//        where("status = ?", @@status_table[:done]).order('updated_at DESC' ).limit(10);
    }

    public function scope_oldest_update($query)
    {
//        where("status != ?", @@status_table[:done]).order('updated_at ASC' ).limit(10);
    }

    public function all_counts()
    {
//    counts = {}
//    @@status_table.each_key {|status| counts[status] = 0 }
//
//    self.group(:status).count(:status).each {|status_value, count|
//counts[@@status_table.key(status_value)] = count
//    }
//    counts
    }

    public function done_month_list()
    {
//    from_month = Time.now - 1.year
//    to_month   = self.to_done_month
//
//    month_list = []
//    while from_month <= to_month do
//    month_list << { date: to_month, count: self.done.select_month(to_month).count}
//      to_month -= 1.month
//    }
//    return month_list
    }

    public function from_done_month()
    {
//    last_task = self.done.last
//    if last_task
//    from_time = last_task.updated_at
//      Time.new(from_time.year, from_time.mon)
//    else
//      Time.now
//    }
    }

    public function to_done_month()
    {
//    first_task = self.done.first
//    if first_task
//    to_time = first_task.updated_at
//      Time.new(to_time.year, to_time.mon)
//    else
//      Time.now
//    }
    }

    public function created_today_count()
    {
//    self.where('created_at >= ? and created_at <= ?', 1.day.ago, Time.now).count
    }

    public function today_touch()
    {
//    self.where('status != ? and updated_at >= ? and updated_at <= ?', @@status_table[:done], 1.day.ago, Time.now).order("updated_at DESC")
    }

    public function csv($options = [])
    {
//
//    csv_data = CSV.generate(options) do |csv|
//csv << ["Book", "Task", "Status", "UpdatedAt"]
//[:doing,:todo_h,:todo_m, :todo_l, :waiting].each do |st|
//self.by_status(st).each do |t|
//csv << [t.book_name, t.msg_without_book_name, t.status_sym, t.updated_at]
//        }
//      }
//      self.done.each do |t|
//csv << [t.book_name, t.msg_without_book_name, t.status_sym, t.updated_at]
//    }
//    #SJISに変換するかどうか悩む
//    #csv_data.encode(Encoding::SJIS)
    }

    public function status_sym()
    {
//    @@status_table.key(status)
    }

    public function update_status($status)
    {
//    self.status = @@status_table[status.to_sym]
    }

    public function get_book_id_in_msg_by_user($user)
    {
//    @@book_name_patterns.each{|pattern|
//      if pattern =~ self.msg
//      return user.books.find_or_create_by_name($1)
//      }
//    }
//
//    nil
    }

    public function msg_without_book_name()
    {
//    return self.msg if self.book == nil
//
//@@book_name_patterns.each{|pattern|
//      if pattern =~ self.msg
//      return self.msg.sub(pattern,"")
//      }
//    }
//
//    self.msg
    }

    public function book_name()
    {
//    if self.book != nil
//    self.book.name
//    else
//        ""
//    }
    }
}
