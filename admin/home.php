<h1 class="welcome-title">Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<section class="content">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-6 col-md-3 mb-4">
            <div class="info-card shadow">
                <div class="info-icon bg-gradient-info">
                    <i class="fas fa-calendar-alt fa-3x"></i>
                </div>
                <div class="info-details">
                    <h4 class="info-title">Events</h4>
                    <p class="info-number"><?php echo $conn->query("SELECT * FROM event_list")->num_rows; ?></p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3 mb-4">
            <div class="info-card shadow">
                <div class="info-icon bg-gradient-primary">
                    <i class="fas fa-users fa-3x"></i>
                </div>
                <div class="info-details">
                    <h4 class="info-title">Listed Audience</h4>
                    <p class="info-number"><?php echo $conn->query("SELECT * FROM event_audience")->num_rows; ?></p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3 mb-4">
            <div class="info-card shadow">
                <div class="info-icon bg-gradient-success">
                    <i class="fas fa-check-circle fa-3x"></i>
                </div>
                <div class="info-details">
                    <h4 class="info-title">Finished Events</h4>
                    <p class="info-number"><?php echo $conn->query("SELECT * FROM event_list WHERE unix_timestamp(datetime_end) <= '".strtotime(date('Y-m-d H:i'))."' ")->num_rows; ?></p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3 mb-4">
            <div class="info-card shadow">
                <div class="info-icon bg-gradient-warning">
                    <i class="fas fa-clock fa-3x"></i>
                </div>
                <div class="info-details">
                    <h4 class="info-title">Ongoing Events</h4>
                    <p class="info-number"><?php echo $conn->query("SELECT * FROM event_list WHERE '".strtotime(date('Y-m-d H:i'))."' BETWEEN unix_timestamp(datetime_start) AND unix_timestamp(datetime_end) ")->num_rows; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* General Styles */
body {
    background-color: #f4f7fc;
    font-family: 'Poppins', sans-serif;
}

h1.welcome-title {
    font-size: 2.8rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 30px;
    color: #34495e;
}

/* Info Card Styles */
.info-card {
    background-color: #ffffff;
    border-radius: 12px;
    display: flex;
    align-items: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    padding: 20px;
}

.info-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
}

.info-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
}

.bg-gradient-info {
    background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
}

.info-details {
    text-align: left;
}

.info-title {
    font-size: 1.4rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 5px;
}

.info-number {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
}

/* Responsive Styles */
@media (max-width: 768px) {
    h1.welcome-title {
        font-size: 2rem;
    }

    .info-card {
        flex-direction: column;
        text-align: center;
    }

    .info-icon {
        margin: 0 0 15px;
    }
}
</style>
