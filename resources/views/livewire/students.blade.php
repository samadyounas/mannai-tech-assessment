<div>
    <form wire:submit.prevent="create" enctype="multipart/form-data">
        <input type="text" wire:model="name" name="name" placeholder="Name">
        @error('name') <span class="error">{{ $message }}</span> @enderror
        <input type="text" wire:model="grade" name="grade" placeholder="Grade">
        @error('grade') <span class="error">{{ $message }}</span> @enderror
        <input type="text" wire:model="department" name="department" placeholder="Department">
        @error('department') <span class="error">{{ $message }}</span> @enderror

        <input type="file" wire:model="filepond" name="filepond" id="avatar">
        <button type="submit">Add Student</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Grade</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->grade }}</td>
                    <td>{{ $student->department }}</td>
                    <td><img src="{{asset('/storage/avatars/').'/'.$student->image}}" width="50"></td>
                    <td>
                        <button wire:click="delete({{ $student->id }})">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

