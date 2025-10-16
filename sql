SET @row := 0;

UPDATE Students_information
JOIN (
  SELECT student_id, (@row := @row + 1) AS new_number
  FROM Students_information
  ORDER BY student_id
) AS t ON Students_information.student_id = t.student_id
SET Students_information.number = t.new_number;
