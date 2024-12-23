CREATE TRIGGER after_hours_update
AFTER UPDATE ON hours
FOR EACH ROW
BEGIN
    -- Check if the 'skill' column was updated (i.e., compare the old and new values)
    IF OLD.skill <> NEW.skill THEN
        -- Dynamically update the corresponding operation column in skillmatrix
        -- using CASE to match the operationname and update the correct column
        UPDATE skillmatrix
        SET
            operation1 = CASE 
                            WHEN NEW.operationname = 'operation1' AND operation1 < NEW.skill THEN NEW.skill 
                            ELSE operation1 
                         END,
            operation2 = CASE 
                            WHEN NEW.operationname = 'operation2' AND operation2 < NEW.skill THEN NEW.skill 
                            ELSE operation2 
                         END,
            operation3 = CASE 
                            WHEN NEW.operationname = 'operation3' AND operation3 < NEW.skill THEN NEW.skill 
                            ELSE operation3 
                         END,
            operation4 = CASE 
                            WHEN NEW.operationname = 'operation4' AND operation4 < NEW.skill THEN NEW.skill 
                            ELSE operation4 
                         END,
            operation5 = CASE 
                            WHEN NEW.operationname = 'operation5' AND operation5 < NEW.skill THEN NEW.skill 
                            ELSE operation5 
                         END,
            operation6 = CASE 
                            WHEN NEW.operationname = 'operation6' AND operation6 < NEW.skill THEN NEW.skill 
                            ELSE operation6 
                         END,
            operation7 = CASE 
                            WHEN NEW.operationname = 'operation7' AND operation7 < NEW.skill THEN NEW.skill 
                            ELSE operation7 
                         END,
            operation8 = CASE 
                            WHEN NEW.operationname = 'operation8' AND operation8 < NEW.skill THEN NEW.skill 
                            ELSE operation8 
                         END,
            operation9 = CASE 
                            WHEN NEW.operationname = 'operation9' AND operation9 < NEW.skill THEN NEW.skill 
                            ELSE operation9 
                         END,
            operation10 = CASE 
                            WHEN NEW.operationname = 'operation10' AND operation10 < NEW.skill THEN NEW.skill 
                            ELSE operation10 
                         END,
            operation11 = CASE 
                            WHEN NEW.operationname = 'operation11' AND operation11 < NEW.skill THEN NEW.skill 
                            ELSE operation11 
                         END,
            operation12 = CASE 
                            WHEN NEW.operationname = 'operation12' AND operation12 < NEW.skill THEN NEW.skill 
                            ELSE operation12 
                         END,
            operation13 = CASE 
                            WHEN NEW.operationname = 'operation13' AND operation13 < NEW.skill THEN NEW.skill 
                            ELSE operation13 
                         END,
            operation14 = CASE 
                            WHEN NEW.operationname = 'operation14' AND operation14 < NEW.skill THEN NEW.skill 
                            ELSE operation14 
                         END,
            operation15 = CASE 
                            WHEN NEW.operationname = 'operation15' AND operation15 < NEW.skill THEN NEW.skill 
                            ELSE operation15 
                         END,
            operation16 = CASE 
                            WHEN NEW.operationname = 'operation16' AND operation16 < NEW.skill THEN NEW.skill 
                            ELSE operation16 
                         END,
            operation17 = CASE 
                            WHEN NEW.operationname = 'operation17' AND operation17 < NEW.skill THEN NEW.skill 
                            ELSE operation17 
                         END,
            operation18 = CASE 
                            WHEN NEW.operationname = 'operation18' AND operation18 < NEW.skill THEN NEW.skill 
                            ELSE operation18 
                         END,
            operation19 = CASE 
                            WHEN NEW.operationname = 'operation19' AND operation19 < NEW.skill THEN NEW.skill 
                            ELSE operation19 
                         END,
            operation20 = CASE 
                            WHEN NEW.operationname = 'operation20' AND operation20 < NEW.skill THEN NEW.skill 
                            ELSE operation20 
                         END
        WHERE TKNO = NEW.TKNO;
    END IF;
END;
