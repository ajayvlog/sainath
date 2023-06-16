ALTER TABLE `m_expanse_group` ADD `type` VARCHAR(10) NOT NULL AFTER `status`;


ALTER TABLE `expanse` ADD `type` VARCHAR(10) NOT NULL AFTER `pay_type`;


UPDATE `m_userprivilege` SET `page_heading` = 'Expense Group Master' WHERE `m_userprivilege`.`page_id` = 41;


UPDATE `m_userprivilege` SET `page_heading` = 'Expense Entry Master' WHERE `m_userprivilege`.`page_id` = 42;


UPDATE `m_userprivilege` SET `page_heading` = 'Expense Report' WHERE `m_userprivilege`.`page_id` = 43;


INSERT INTO `m_userprivilege` (`page_id`, `menuname`, `page_heading`, `pagelink`, `enable`, `createdby`, `ipaddress`, `lastupdated`, `createdate`) VALUES (NULL, 'Master', 'Income Group Master', 'income_head.php', '', '', '', '', ''), (NULL, 'Master', 'Income Entry Master', 'income_group_entry.php', '', '', '', '', '');


INSERT INTO `m_userprivilege` (`page_id`, `menuname`, `page_heading`, `pagelink`, `enable`, `createdby`, `ipaddress`, `lastupdated`, `createdate`) VALUES (NULL, 'Master', 'Income Report', 'income_report.php', '', '', '', '', '');



INSERT INTO `m_userprivilege` (`page_id`, `menuname`, `page_heading`, `pagelink`, `enable`, `createdby`, `ipaddress`, `lastupdated`, `createdate`) VALUES (NULL, 'Master', 'Cash Book', 'cash_book.php', '', '', '', '', '');