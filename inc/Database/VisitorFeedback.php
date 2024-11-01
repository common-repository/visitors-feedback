<?php

namespace VSTR\Database;

class VisitorFeedback {
    protected $table;
    protected $version = 1;
    protected $name = 'vstr_visitor_feedbacks';

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    public function getName()
    {
        global $wpdb;
        return $wpdb->prefix . $this->name;
    }

    /**
     * Add videos table
     * This is used for global video analytics
     * @return void
     */
    public function install()
    {
        return $this->table->create($this->name, "
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `feedback` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
            `created_at` timestamp NULL DEFAULT current_timestamp(),
            `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            PRIMARY KEY (id)
            ", $this->version);
    }

    /**
     * Uninstall tables
     *
     * @return void
     */
    public function uninstall()
    {
        $this->table->drop($this->getName());
    }
}
