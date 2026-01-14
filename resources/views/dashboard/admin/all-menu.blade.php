@foreach ($listMenu as $menu)
<div class="col-md-4 mt-3" id="menuList">
    <div class="card">
        <img src="/images/menu/{{$menu->menu_image}}" class="img-fluid img-tumb mx-auto" alt="...">
        <div class="card-body">
            <h4 class="text-center">{{$menu->name}}</h4>
            <p class="card-text text-center">&lpar;{{$menu->price}}&rpar; </p>
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary" data-id="{{$menu->id}}" id="editBtn"> Edit </button>
                <button class="btn btn-danger" data-id="{{$menu->id}}" id="deleteBtn"> Delete </button>
            </div>

        </div>
    </div>
</div>

@endforeach