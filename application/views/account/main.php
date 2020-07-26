<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Hello <?php echo $_SESSION['authorize']['name']; ?></div>
        <div class="card-body">
            <form action="/logout" method="post">
                <button type="submit" class="btn btn-primary btn-block">Logout</button>
            </form>
        </div>
    </div>
</div>
