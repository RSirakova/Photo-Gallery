		-- Създаване на БД
			CREATE DATABASE albums;
			USE albums;
		--	Таблици

		-- Таблица съхраняваща информация за снимките
			CREATE TABLE images (
				id int NOT NULL AUTO_INCREMENT,
				image varchar(256) NOT NULL,
				image_text text NOT NULL,
				PRIMARY KEY (id)
				)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
				
	
		-- Таблица съхраняваща информация за студентите
			CREATE TABLE studentinfo (
				id int NOT NULL AUTO_INCREMENT,
				firstName varchar(40) NOT NULL,
				lastName varchar(40) NOT NULL,
				password varchar(256) NOT NULL,
				email varchar(50) NOT NULL,
				fn int NOT NULL UNIQUE,
				studentSpeciality varchar(3) NOT NULL,
				studentCourse int NOT NULL,
				studentGroup int NOT NULL,
				studentIssue int NOT NULL,
				PRIMARY KEY (id)
				);

		-- Таблица за връзката между студент и неговите снимки					
					
			CREATE TABLE studentimages (
				studentimagesId int NOT NULL AUTO_INCREMENT,
				studentId int NOT NULL,
				imageId int NOT NULL,
				PRIMARY KEY (studentimagesId)
				);
				
			ALTER TABLE studentimages
			ADD CONSTRAINT imageFK FOREIGN KEY (imageId) REFERENCES images (id) ON DELETE CASCADE ON UPDATE CASCADE,
			ADD CONSTRAINT studentFK FOREIGN KEY (studentId) REFERENCES studentinfo (id) ON DELETE CASCADE ON UPDATE CASCADE;

						
		-- Таблица съхраняваща информация за фотографите
				CREATE TABLE photographerinfo (
				id int NOT NULL AUTO_INCREMENT,
				firstName varchar(40) NOT NULL,
				lastName varchar(40) NOT NULL,
				password varchar(256) NOT NULL,
				email varchar(50) NOT NULL,
				professionalNumber int NOT NULL UNIQUE,
				PRIMARY KEY (id)
				);
				
				
		-- Таблица съдържаща информация за заявяването на фотосесия	
				
				CREATE TABLE requestPhotosession (
				requestId int NOT NULL AUTO_INCREMENT,
				studentId int NOT NULL,
				photographerId int NOT NULL,
				type varchar(15) NOT NULL,
				dateOfPhotosession DATE  NOT NULL,				
				status varchar(20)  NOT NULL,
				PRIMARY KEY (requestId)
				);
		
		ALTER TABLE requestPhotosession 
			ADD CONSTRAINT studentFK3 FOREIGN KEY (studentId) REFERENCES studentinfo(id) ON DELETE CASCADE ON UPDATE CASCADE,
			ADD CONSTRAINT photographerFK3 FOREIGN KEY (photographerId) REFERENCES photographerinfo(id) ON DELETE CASCADE ON UPDATE CASCADE;

		-- Таблица съдържаща информация за поръчката на сувенири със снимки
					
				CREATE TABLE orderSouvenirs (
				orderId int NOT NULL AUTO_INCREMENT,
				photographerId int NOT NULL,
				studentId int NOT NULL,
				idImage int NOT NULL,
				souvenir varchar(30) NOT NULL,
				dateOfOrder DATE  NOT NULL,						
				status varchar(20)  NOT NULL,	
				amount int NOT NULL,
				PRIMARY KEY (orderId)
				);

			ALTER TABLE orderSouvenirs
			ADD CONSTRAINT studentFK2 FOREIGN KEY (studentId) REFERENCES studentinfo(id) ON DELETE CASCADE ON UPDATE CASCADE,
			ADD CONSTRAINT photographerFK2 FOREIGN KEY (photographerId) REFERENCES photographerinfo(id) ON DELETE CASCADE ON UPDATE CASCADE,
			ADD CONSTRAINT imageFK2 FOREIGN KEY (idImage) REFERENCES images(id) ON DELETE CASCADE ON UPDATE CASCADE;


		-- Вмъкване на тестови данни
		
		INSERT INTO studentinfo (firstName, lastName,password,email,fn,studentSpeciality,studentCourse,studentGroup,studentIssue)
							VALUES (N'Румяна', N'Сиракова', '$2y$10$GMNZerYuxNyJBQ5wAP/bK.BM805h/wIw4Rj1Wkwq3SIPe3mWjA8Au','rumi@mail.bg',81595,N'КН',4,7,2017);
								
		INSERT INTO studentinfo (firstName, lastName,password,email,fn,studentSpeciality,studentCourse,studentGroup,studentIssue)
							VALUES (N'Димитър', N'Николов', '$2y$10$dJJuvdFvOTGqoxrPOTnpUeIK3nulW2zEdyfPQYnkhK/5fBfi8k5oi','mitko@abv.bg',81589,N'КН',4,6,2017);
								
								
		INSERT INTO photographerinfo (firstName, lastName,password,email,professionalNumber)
							VALUES (N'Иван', N'Иванов', '$2y$10$KwFe.jhF3kZrCmIV7Qv8teQ1cUgCmyh3w5HHPDK4NZDulltu3UyZy','ivan@abv.bg',90000);
								
			INSERT INTO photographerinfo (firstName, lastName,password,email,professionalNumber)
							VALUES (N'Петър', N'Петров', '$2y$10$MFpLmWz4ddLLwxqIVaobm.Hn3FnPy8vWQ3m0IWRyUCM0ciPuWtO9a','petar@abv.bg',80000);
													