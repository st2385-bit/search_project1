

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



CREATE TABLE `Students_information` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `class` varchar(10) NOT NULL,
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `Students_information` (`student_id`, `first_name`, `last_name`, `nickname`, `class`, `number`) VALUES
(3959, 'สมชาย', 'gflgneihjd', 'fjjfkghjg', 'ม.3/2', 12),
(4856, 'fjigknumbd', 'fleighw', 'toni', 'm.4/1', 46)
(3456,'qwer','asdf','bmdn','m.7/36',67);


ALTER TABLE `Students_information`
  ADD PRIMARY KEY (`student_id`);


ALTER TABLE `Students_information`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT;
COMMIT;
