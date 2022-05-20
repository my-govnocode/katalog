<?php
use yii\helpers\Html;
?>

<?php include __DIR__ . '/../layouts/main.php'; ?>

<table class="table table-striped table-hover">
<thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">username</th>
      <th scope="col">email</th>
      <th scope="col">role</th>
      <th scope="col">created_at</th>
      <th scope="col">updated_at</th>
    </tr>
  </thead>
  <tbody>
      <?php foreach($users as $user): ?>
    <tr>
      <th scope="row"><?= Html::encode($user->id); ?></th>
      <td><?= Html::encode($user->username); ?></td>
      <td><?= Html::encode($user->email); ?></td>
      <td><?= Html::encode($user->role); ?></td>
      <td><?= Html::encode($user->created_at); ?></td>
      <td><?= Html::encode($user->updated_at); ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>