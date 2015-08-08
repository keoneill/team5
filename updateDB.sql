/* This procedure updates the table 'user_info' from data in the table 'dow_stocks'

DROP PROCEDURE IF EXISTS updateDB;

DELIMITER //

CREATE PROCEDURE updateDB()
BEGIN
	DECLARE done TINYINT DEFAULT FALSE;
	DECLARE update_count INT DEFAULT 0;
	DECLARE user_var VARCHAR(30);
	DECLARE stock_pick_var VARCHAR(10);
	DECLARE points_var INT;
	DECLARE num_games_var INT;

	DECLARE players_cursor CURSOR FOR
		SELECT username, dowGameChoice, numGamesPlayed FROM user_info
		WHERE NOT dowGameChoice = '';
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND 
	 	SET done = TRUE;

	OPEN players_cursor;
	
	read_loop: LOOP 
		FETCH players_cursor INTO user_var, stock_pick_var, num_games_var;
		IF done THEN
			LEAVE read_loop;
		END IF;

		SET points_var = (SELECT points FROM dow_stocks 
						WHERE ticker = stock_pick_var);
		SET update_count = update_count + 1;

		UPDATE user_info
		SET dowGameChoice = '',
			totalScore = totalScore + points_var,
			currentScore = points_var,
			averageScore = totalScore / (num_games_var + 1),
			numGamesPlayed = num_games_var + 1,
			prevChoice = stock_pick_var
		WHERE username = user_var;

	END LOOP;

	CLOSE players_cursor;

	SELECT CONCAT(update_count, ' row(s) updated.');

END//

DELIMITER ;
