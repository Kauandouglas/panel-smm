<?php

use App\Http\Controllers\Dashboard\ApiController as ApiControllerDashboard;
use App\Http\Controllers\Dashboard\AuthController as AuthControllerDashboard;
use App\Http\Controllers\Dashboard\CategoryController as CategoryControllerDashboard;
use App\Http\Controllers\Dashboard\ConfigController;
use App\Http\Controllers\Dashboard\LinkController;
use App\Http\Controllers\Dashboard\OrderController as OrderControllerDashboard;
use App\Http\Controllers\Dashboard\PaymentController as PaymentControllerDashboard;
use App\Http\Controllers\Dashboard\RefillController as RefillControllerDashboard;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\Dashboard\ServiceController as ServiceControllerDashboard;
use App\Http\Controllers\Dashboard\SupportController as SupportControllerDashboard;
use App\Http\Controllers\Dashboard\SupportMessageController as SupportMessageControllerDashboard;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\UserServicePriceController;
use App\Http\Controllers\Forgot\ForgotController;
use App\Http\Controllers\Panel\AccountController;
use App\Http\Controllers\Panel\ApiController;
use App\Http\Controllers\Panel\AuthController;
use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\NotificationController;
use App\Http\Controllers\Panel\OrderController;
use App\Http\Controllers\Panel\PaymentController;
use App\Http\Controllers\Panel\RefillController;
use App\Http\Controllers\Panel\ServiceController;
use App\Http\Controllers\Panel\SupportController;
use App\Http\Controllers\Panel\SupportMessageController;
use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Panel
Route::group(['as' => 'panel.', 'prefix' => 'painel'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::name('auth.')->group(function () {
            Route::get('/login', 'formLogin')->name('formLogin');
            Route::post('/login', 'login')->name('login');
            Route::post('/sair', 'logout')->name('logout');
        });
    });

    // Accounts
    Route::controller(AccountController::class)->group(function () {
        Route::name('accounts.')->group(function () {
            Route::get('/cadastrar', 'create')->name('create');
            Route::post('/cadastrar', 'store')->name('store');
        });
    });

    Route::middleware('role:1')->group(function () {
        // Index
        Route::get('/', [AuthController::class, 'index'])->name('index');

        // Orders
        Route::controller(OrderController::class)->group(function () {
            Route::name('orders.')->group(function () {
                Route::get('/pedidos', 'index')->name('index');
                Route::get('/pedidos/novo', 'create')->name('create');
                Route::post('/pedidos/novo', 'store')->name('store');
                Route::get('/pedidos/massa', 'mass')->name('mass');
                Route::post('/pedidos/massa', 'massDo')->name('massDo');
            });
        });

        // Services
        Route::controller(ServiceController::class)->group(function () {
            Route::name('services.')->group(function () {
                Route::get('/servicos', 'index')->name('index');
                Route::get('/servicos/listar', 'list')->name('list');
            });
        });

        // Services
        Route::controller(CategoryController::class)->group(function () {
            Route::name('categories.')->group(function () {
                Route::get('/categoria/listar-servicos', 'listService')->name('listService');
            });
        });

        // Supports
        Route::controller(SupportController::class)->group(function () {
            Route::name('supports.')->group(function () {
                Route::post('/suportes', 'store')->name('store')
                    ->middleware('throttle:5,1');
                Route::get('/suportes/{support?}', 'index')->name('index');
            });
        });

        // Support Messages
        Route::controller(SupportMessageController::class)->group(function () {
            Route::name('supportMessages.')->group(function () {
                Route::post('/suporte-mensagens/{support}', 'store')->name('store')
                    ->middleware('throttle:60,1');
            });
        });

        // Refills
        Route::controller(RefillController::class)->group(function () {
            Route::name('refills.')->group(function () {
                Route::get('/refills', 'index')->name('index');
                Route::post('/refills/{order}', 'store')->name('store');
            });
        });

        // Payments
        Route::controller(PaymentController::class)->group(function () {
            Route::name('payments.')->group(function () {
                Route::get('/adicionar-saldo', 'index')->name('index');
                Route::post('/adicionar-saldo', 'store')->name('store');
                Route::post('/adicionar-saldo/stripe', 'stripeStore')->name('stripeStore');
                Route::post('/adicionar-saldo/{payment}', 'show')->name('show');
                Route::view('/adicionar-saldo/sucess-payment-sripe', 'panel.payments.sucess-payment-sripe');
            });
        });

        // Accounts
        Route::controller(AccountController::class)->group(function () {
            Route::name('accounts.')->group(function () {
                Route::get('/meu-perfil', 'edit')->name('edit');
                Route::put('/meu-perfil', 'update')->name('update');
                Route::post('/gerar-token', 'token')->name('token');
            });
        });

        // Notifications
        Route::controller(NotificationController::class)->group(function () {
            Route::name('notifications.')->group(function () {
                Route::get('/notificacoes', 'index')->name('index');
            });
        });

        // API
        Route::controller(ApiController::class)->group(function () {
            Route::name('api.')->group(function () {
                Route::get('/api-doc', 'index')->name('index');
            });
        });

        // Change Theme
        Route::post('/theme/change', function () {
            if (!Cookie::has('theme')) {
                cookie()->queue(cookie('theme', 'dark', 21600));
            } else {
                cookie()->queue(cookie()->forget('theme'));
            }

            return response([
                'success' => true
            ]);
        })->name('theme.change');
    });
});

// Dashboard
Route::group(['as' => 'dashboard.', 'prefix' => 'admin'], function () {
    Route::controller(AuthControllerDashboard::class)->group(function () {
        Route::name('auth.')->group(function () {
            Route::get('/login', 'formLogin')->name('formLogin');
            Route::post('/login', 'login')->name('login');
            Route::post('/sair', 'logout')->name('logout');
        });
    });

    Route::middleware('role:2')->group(callback: function () {
        // Index
        Route::get('/', [AuthControllerDashboard::class, 'index'])->name('index');

        // Users
        Route::controller(UserController::class)->group(function () {
            Route::name('users.')->group(function () {
                Route::get('/usuarios', 'index')->name('index');
                Route::get('/usuarios/edit/{user}', 'edit')->name('edit');
                Route::put('/usuarios/edit/{user}', 'update')->name('update');
                Route::post('/usuarios/status/{user}', 'status')->name('status');
                Route::post('/usuarios/export', 'export')->name('export');
            });
        });

        // Orders
        Route::controller(OrderControllerDashboard::class)->group(function () {
            Route::name('orders.')->group(function () {
                Route::get('/pedidos', 'index')->name('index');
                Route::put('/pedidos/editar-link/{order}', [OrderControllerDashboard::class, 'editLink'])
                    ->name('editLink');
                Route::post('/pedidos/reembolsar/{order}', [OrderControllerDashboard::class, 'repay'])
                    ->name('repay');
                Route::post('/pedidos/completar/{order}', [OrderControllerDashboard::class, 'finish'])
                    ->name('finish');
                Route::post('/pedidos/reenviar', [OrderControllerDashboard::class, 'resend'])->name('resend');
            });
        });

        // Refills
        Route::controller(RefillControllerDashboard::class)->group(function () {
            Route::name('refills.')->group(function () {
                Route::get('/refills', 'index')->name('index');
                Route::post('/refills/{order}/{user}', 'store')->name('store');
            });
        });

        // Services
        Route::controller(ServiceControllerDashboard::class)->group(function () {
            Route::name('services.')->group(function () {
                Route::get('/servicos', 'index')->name('index');
                Route::post('/servicos', 'store')->name('store');
                Route::put('/servicos/{service}', 'update')->name('update');
                Route::post('/servicos/desabilitar/{service}', 'disabled')->name('disabled');
                Route::get('/servicos/listar', 'list')->name('list');
                Route::delete('/servicos/{service}', 'destroy')->name('destroy');
                Route::post('/servicos/importar', 'import')->name('import');
            });
        });

        // Categories
        Route::controller(CategoryControllerDashboard::class)->group(function () {
            Route::name('categories.')->group(function () {
                Route::post('/categorias', 'store')->name('store');
                Route::post('/categorias/desabilitar/{category}', 'disabled')->name('disabled');
                Route::post('/categorias/ordernar', 'sort')->name('sort');
                Route::delete('/categorias/{category}', 'destroy')->name('destroy');
            });
        });

        // Payments
        Route::controller(PaymentControllerDashboard::class)->group(function () {
            Route::name('payments.')->group(function () {
                Route::get('/pagamentos', 'index')->name('index');
                Route::post('/pagamentos/novo', 'store')->name('store');
            });
        });

        // Supports
        Route::controller(SupportControllerDashboard::class)->group(function () {
            Route::name('supports.')->group(function () {
                Route::get('/suportes/{support?}', 'index')->name('index');
                Route::post('/suportes/finalizar/{support}', 'finish')->name('finish');
            });
        });

        // Support Messages
        Route::controller(SupportMessageControllerDashboard::class)->group(function () {
            Route::name('supportMessages.')->group(function () {
                Route::post('/suporte-mensagens/{support}', 'store')->name('store');
            });
        });

        // User Service Prices
        Route::controller(UserServicePriceController::class)->group(function () {
            Route::name('userServicePrices.')->group(function () {
                Route::get('/servico-preco/{user}', 'index')->name('index');
                Route::post('/servico-preco/{user}', 'store')->name('store');
                Route::delete('/servico-preco/{userServicePrice}', 'destroy')->name('destroy');
            });
        });

        // Apis
        Route::resource('apis', ApiControllerDashboard::class)->only('index', 'store', 'update', 'destroy');

        // Configs
        Route::controller(ConfigController::class)->group(function () {
            Route::name('configs.')->group(function () {
                Route::get('/configuracao', 'edit')->name('edit');
                Route::put('/configuracao', 'update')->name('update');
            });
        });

        // Reports
        Route::controller(ReportController::class)->group(function () {
            Route::name('reports.')->group(function () {
                Route::get('/relatorios/ordens', 'order')->name('order');
                Route::get('/relatorios/pagamentos', 'payment')->name('payment');
                Route::get('/relatorios/tickets', 'ticket')->name('ticket');
                Route::get('/relatorios/ganhos', 'profit')->name('profit');
            });
        });

        // Reports
        Route::controller(LinkController::class)->group(function () {
            Route::name('links.')->group(function () {
                Route::get('/links', 'index')->name('index');
                Route::post('/links', 'store')->name('store');
            });
        });
    });
});

// Forgot
Route::middleware('guest')->group(function () {
    Route::controller(ForgotController::class)->group(function () {
        Route::get('/esqueceu-a-senha', 'passwordRequest')->name('password.request');
        Route::post('/esqueceu-a-senha', 'passwordEmail')->name('password.email');
        Route::get('/alterar-senha/{token}', 'passwordReset')->name('password.reset');
        Route::post('/alterar-senha', 'passwordUpdate')->name('password.update');
    });
});

// Web
Route::group(['as' => 'web.', 'middleware' => 'guest'], function () {
    Route::controller(WebController::class)->group(function () {
        Route::get('/', 'home')->name('home');
        Route::get('/servicos', 'service')->name('service');
        Route::view('/termos-de-uso', 'web.terms')->name('term');
        Route::view('/politica-de-privacidade', 'web.privacy')->name('privacy');
        Route::get('/ref/{code}', function ($code) {
            $link = \App\Models\Link::where('slug', $code)->first();
            if ($link) {
                $link->click = $link->click + 1;
                $link->update();
            }
            return redirect('/');
        })->name('ref');
    });
});
