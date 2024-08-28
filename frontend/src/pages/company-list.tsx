import * as React from 'react';
import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemButton from '@mui/material/ListItemButton';
import ListItemText from '@mui/material/ListItemText';
import IconButton from '@mui/material/IconButton';
import Typography from '@mui/material/Typography';
import { useRouter } from 'next/router'; // useRouterをインポート

export default function CompanyList() {
  const router = useRouter(); // useRouterを使用

  // テストデータの作成
  const companyData = [
    { id: 1, name: "株式会社一番" },
    { id: 2, name: "株式会社二番" },
    { id: 3, name: "株式会社三番" },
    { id: 4, name: "株式会社四番" }
  ];

  // ページ遷移を処理する関数
  const handleNavigation = () => {
    router.push('/'); // ホームに遷移
  };

  return (
    <List sx={{ width: '100%', height: '100vh', bgcolor: 'background.paper', overflow: 'auto' }}>
      <Typography variant="h2" component="h1" sx={{ textAlign: 'center', marginY: 4 }}>
        会社一覧
      </Typography>
      {companyData.map((company) => {
        const labelId = `company-list-label-${company.id}`;

        return (
          <ListItem
            key={company.id}
            secondaryAction={
              <IconButton edge="end" aria-label="comments">
              </IconButton>
            }
            disablePadding
          >
            <ListItemButton role={undefined} onClick={handleNavigation} dense>
              <ListItemText 
                id={labelId} 
                primary={company.name}
                sx={{ textAlign: 'center' }}
              />
            </ListItemButton>
          </ListItem>
        );
      })}
    </List>
  );
}

