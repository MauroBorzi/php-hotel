<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>PHP Hotels</title>
</head>

<body>
  <?php

  $hotels = [
    [
      'name' => 'Hotel Belvedere',
      'description' => 'Hotel Belvedere Descrizione',
      'parking' => true,
      'vote' => 4,
      'distance_to_center' => 10.4
    ],
    [
      'name' => 'Hotel Futuro',
      'description' => 'Hotel Futuro Descrizione',
      'parking' => true,
      'vote' => 2,
      'distance_to_center' => 2
    ],
    [
      'name' => 'Hotel Rivamare',
      'description' => 'Hotel Rivamare Descrizione',
      'parking' => false,
      'vote' => 1,
      'distance_to_center' => 1
    ],
    [
      'name' => 'Hotel Bellavista',
      'description' => 'Hotel Bellavista Descrizione',
      'parking' => false,
      'vote' => 5,
      'distance_to_center' => 5.5
    ],
    [
      'name' => 'Hotel Milano',
      'description' => 'Hotel Milano Descrizione',
      'parking' => true,
      'vote' => 2,
      'distance_to_center' => 50
    ],
  ];

  $filterParking = isset($_GET['parking']) && $_GET['parking'] === '1';
  $filterVote = isset($_GET['min_vote']) && is_numeric($_GET['min_vote']) ? (int)$_GET['min_vote'] : null;

  $filteredHotels = array_filter($hotels, function ($hotel) use ($filterParking, $filterVote) {
    if ($filterParking && !$hotel['parking']) return false;
    if ($filterVote !== null && $hotel['vote'] < $filterVote) return false;
    return true;
  });
  ?>

  <div class="container">
    <h1 class="text-center py-3">Lista Hotel</h1>

    <form method="GET" class="mb-4">
      <div class="row justify-content-center g-3 align-items-end">
        <div class="col-12 col-md-auto d-flex align-items-center">
          <div class="form-check form-switch">
            <input
              class="form-check-input"
              type="checkbox"
              name="parking"
              value="1"
              id="parking"
              <?= $filterParking ? 'checked' : '' ?>
              onchange="this.form.submit()">
            <label class="form-check-label" for="parking">Solo hotel con parcheggio</label>
          </div>
        </div>

        <div class="col-12 col-md-4">
          <label for="min_vote" class="form-label">Voto minimo</label>
          <input
            type="number"
            class="form-control"
            name="min_vote"
            id="min_vote"
            min="1"
            max="5"
            placeholder="Inserisci voto minimo"
            value="<?= $filterVote ?? '' ?>"
            onchange="this.form.submit()">
        </div>

        <div class="col-12 col-md-auto d-flex flex-column">
          <label class="form-label invisible">Reset</label>
          <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-secondary mt-1 mt-md-0">Reset</a>
        </div>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover align-middle shadow-sm">
        <thead class="table-dark">
          <tr>
            <th>Nome</th>
            <th>Descrizione</th>
            <th>Parcheggio</th>
            <th>Voto</th>
            <th>Distanza dal centro (km)</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($filteredHotels)): ?>
            <tr>
              <td colspan="5" class="text-center text-muted">Nessun hotel trovato con i criteri selezionati.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($filteredHotels as $hotel): ?>
              <tr>
                <td><?= htmlspecialchars($hotel['name']) ?></td>
                <td><?= htmlspecialchars($hotel['description']) ?></td>
                <td><?= $hotel['parking'] ? 'Sì' : 'No' ?></td>
                <td><?= $hotel['vote'] ?></td>
                <td><?= $hotel['distance_to_center'] ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>