
<?php 

    include('config/db_connect.php');

    $email = $title = $ingredients = "";
    $errors = array('email'=>'', 'title'=>'','ingredients'=>'');

    //POST check 
    if(isset($_POST["submit"])){
        
        //check email
        if(empty($_POST['email'])){
            $errors['email'] = 'An email is recquired <br />';
        }else{
            $email =  $_POST['email']; // 'htmlspecialchars' to avoid xxs attack]\
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Email must be a valid email address <br />';
            }
        }
        //check title
        if(empty($_POST['title'])){
            $errors['title'] = 'A title recquired <br />';
        }else{
            $title = $_POST['title'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
                $errors['title'] =  'Title must be letters and spaces only <br />';
            }
        }
        //check ingredients
        if(empty($_POST['ingredients'])){
            $errors['ingredients'] = 'At least one ingredient is recquired <br />';
        }else{
            $ingredients = $_POST['ingredients'];
            if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
                $errors['ingredients'] =  'Ingredients must be a comma separated list  <br />';
            }
        }

        //redirecting
        if(array_filter($errors)):
            //echo 'form is invalid';
        else: //here we add the input to the database when for is valid
            //escape any bad sql or sensitve characters
            $email =mysqli_real_escape_string($conn, $_POST['email']);
            $title =mysqli_real_escape_string($conn, $_POST['title']);
            $ingredients =mysqli_real_escape_string($conn, $_POST['ingredients']);

            //create sql
            $sql ="INSERT INTO pizzas(title, email, ingredients) VALUES('$title', '$email', '$ingredients')";

            //sav3e to db
            if(mysqli_query($conn, $sql)):
                // success and redirect
                header('Location: index.php');
            else:
                echo"query error" . mysqli_error($conn);
            endif;

        endif;

    } //end POST check 
   
?>

<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php'); ?>

    <section class="container grey-text">
        <h4 class="center">Add a Pizza</h4>
        <form class="white" action="add.php" method="POST">  <!-- GETting the input turned to POST, a more secure version -->

                <label for="">Your Email:</label>
                <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
                <div class="red-text"><?php echo $errors['email']?></div>

                <label for="">Pizza Title:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
                <div class="red-text"><?php echo $errors['title']?></div>

                <label for="">Ingredients (comma separated):</label>
                <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
                <div class="red-text"><?php echo $errors['ingredients']?>
                </div>

                <div class="center">
                    <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
                </div>

            </form>
    </section>
    
    <?php include('templates/footer.php'); ?>
    
</html>