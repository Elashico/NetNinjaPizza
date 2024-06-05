<?php

    include('config/db_connect.php');

    //writwe query for all pizza
    $sql = 'SELECT title, ingredients, id FROM pizzas ORDER BY created_at';

    // make query & result
    $result = mysqli_query($conn, $sql);

    // fetch the resulting ALL rows as an array
    $pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC); 

    //free result from memory
    mysqli_free_result($result);

    //close connection
    mysqli_close($conn);
    
    //print_r($pizzas);

?>

<!-- shift + 1 -->
<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php'); ?>

    <h4 class="center grey-text">Pizzas!</h4>

    <div class="container">
        <div class="row">

            <?php foreach($pizzas as $pizza): ?><!-- start of foreach -->

                <div class="col s6 md3"><!-- CARD template start -->
                    <div class="card z-depth-0">
                        <div class="card-content center">
                            <h6><?php echo htmlspecialchars($pizza['title']); ?></h6>
                            <div>
                            <ul> <!--  to list out ingredients -->
                                <?php foreach(explode(',',$pizza['ingredients']) as $ing): ?>
                                <li><?php echo htmlspecialchars($ing) ?></li>
                                <?php endforeach; ?>
                            </ul> <!--  end to list out ingredients -->
                            </div>
                        </div>
                        <div class="card-action right-align">
                            <a class="brand-text" href="details.php?id=<?php echo $pizza['id']?>">more info</a>
                        </div>
                    </div>
                </div><!-- CARD template end -->
            
            <?php endforeach; ?><!-- end of foreach -->

            <?php if(count($pizzas) >= 2): ?>
                <p>there are 2 or more pizzas</p>
            <?php else: ?>
                <p>there are less than 2 pizzas</p>
            <?php endif; ?>

        </div>
    </div>
    
    <?php include('templates/footer.php'); ?>
</html>