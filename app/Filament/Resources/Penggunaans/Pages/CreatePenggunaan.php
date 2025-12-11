<?php

namespace App\Filament\Resources\Penggunaans\Pages;

use App\Filament\Resources\Penggunaans\PenggunaanResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use App\Notifications\PenggunaanPengajuanMail;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class CreatePenggunaan extends CreateRecord
{
    protected static string $resource = PenggunaanResource::class;

    protected function getRedirectUrl(): string
    {
        // Mengarahkan kembali ke halaman 'index' (ListBarangs)
        return $this->getResource()::getUrl('index');
    }

    protected function getFormSchema(): array
    {
        return PenggunaanResource::create();
    }
   


   public function afterCreate(): void{

        $record = $this->record;
         $admins = User::where('role', 'admin')->get();
         $record->load('items');


          // Ambil barang yang diajukan
    $items = $record->items->map(function ($item) {
        return [
            'nama' => $item->bmn->nama_barang ?? '-',
            'kode' => $item->bmn->kode_barang ?? '-',

        ];
    })->toArray();

    foreach ($admins as $admin) {

        // Email Pengajuan
        $admin->notify(new PenggunaanPengajuanMail(
            title: 'Pengajuan Penggunaan Baru',
            message: "{$record->user->name} mengajukan penggunaan barang.",
            status: 'Diajukan',
            statusColor: 'primary',
            items: $items,
            id: $record->id
        ));


        Notification::make()
                    ->title('Penggunaan Baru Ditambahkan')
                    ->body($record->user->name . ' membuat pengajuan peminjaman.')
                    ->actions([
                        Action::make('lihat')
                            ->button()
                            ->markAsRead()
                            ->url(PenggunaanResource::getUrl('edit', ['record' => $this->record])),
                    ])
                    ->sendToDatabase($admin)      // tampil di panel filament
                    ->broadcast($admin);          // realtime via pusher
        }
    }
        
        protected function mutateFormDataBeforeCreate(array $data): array
        {
            $data['user_id'] = auth()->id();
            $data['tanggal_penggunaan'] = now()->toDateString();
            $data['status'] = 'Diajukan';
            return $data;
        }
    }
class EditPenggunaan extends EditRecord
{
    protected static string $resource = PenggunaanResource::class;  
}