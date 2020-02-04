# aestedstocks
Home stock management system with barcode scanner

Local PC:
- run composer install
- create .env.local file
- setup database connection (xampp: 127.0.0.1 root/-)
- run php bin/console doctrine:migrations:migrate
- create user : 
INSERT INTO `user` (`id`, `username`, `roles`, `password`, `email`, `created_at`, `modified_at`, `firstname`, `lastname`) VALUES (NULL, 'admin', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$QmdrY0NpbDc0cHNJTldCbA$V2S9sqXKTb8LdTrvQ5tt6MdINF3GEdOPMMpRLAY+LMU', 'michelhamelink@gmail.com', '2020-02-04 23:44:55', NULL, NULL, NULL)

- update symfony: composer update "symfony/*" --with-all-dependencies