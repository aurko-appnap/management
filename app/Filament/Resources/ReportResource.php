<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Report;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\Pages\CustomerDetail;
use App\Filament\Resources\ReportResource\Pages\CustomerList;
use App\Filament\Resources\ReportResource\Pages\CustomerSummary;
use App\Filament\Resources\ReportResource\Pages\NewCustomerReport;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ReportResource\RelationManagers;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Action::make('sales_report')
                        ->label('Sale Report')
                        ->color('success')
                        ->icon('heroicon-o-book-open')
                        ->url('reports/sales-report'),
                    
                    Action::make('popular-product-list')
                        ->label('Products Selling Summary')
                        ->color('success')
                        ->icon('heroicon-o-book-open')
                        ->url('/admin/reports/popular-product-list'),
                    
                    Action::make('customer-summary')
                        ->label('Customers Summary Report')
                        ->color('success')
                        ->icon('heroicon-o-book-open')
                        ->url('/admin/reports/customer-summary'),
                    
                    Action::make('customer-list')
                        ->label('Detailed Customers Report')
                        ->color('success')
                        ->icon('heroicon-o-book-open')
                        ->url('/admin/reports/customer-list'),
                    
                    Action::make('new-customer-report')
                        ->label('New Customer Report')
                        ->color('success')
                        ->icon('heroicon-o-book-open')
                        ->url('/admin/reports/new-customer-report'),
                ])
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
            'sales-report' => Pages\SalesReport::route('/sales-report'),
            'popular-product-list' => Pages\PopularProductList::route('/popular-product-list'),
            'customer-summary' => CustomerSummary::route('/customer-summary'),
            'customer-list' => CustomerList::route('/customer-list'),
            'customer-detail' => CustomerDetail::route('/customer-detail'),
            'new-customer-report' => NewCustomerReport::route('/new-customer-report'),
        ];
    }    
}
