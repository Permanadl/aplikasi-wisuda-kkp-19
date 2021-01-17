@for ($i = 0; $i < $rate; $i++)
<span class="text-warning">
    <i class="fa fa-star"></i>
</span>
@endfor
@for ($i = 0; $i < 5 - $rate; $i++)
<span class="text-muted">
    <i class="fa fa-star"></i>
</span>
@endfor
